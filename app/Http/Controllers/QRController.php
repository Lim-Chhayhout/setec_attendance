<?php

namespace App\Http\Controllers;

use App\Models\QrCode as ModelQrCode;
use App\Models\QrCodeDetail as ModelQrCodeDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRController extends Controller
{   

    public function createQR(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:100',
            'group' => 'required|string|max:100',
            'room' => 'required|string|max:100',
            'time_start_study' => 'required',
            'time_end_study' => 'required',
            'duration' => 'required|integer|min:1|max:1444',
            'note' => 'nullable|string',
        ]);

        $user = Auth::user();

        $teacherId = $user->teacher->id;
        $token = Str::random(32);
        $now = Carbon::now();
        $expiresAt = $now->copy()->addMinutes((int) $request->duration);
        $ip = $request->ip();
        $ipPrefix = implode('.', array_slice(explode('.', $ip), 0, 3));

        $qrCode = ModelQrCode::create([
            'qr_token' => $token,
            'ip_address' => $ipPrefix,
            'teacher_id' => $teacherId,
            'duration_min' => $request->duration,
            'created_at' => $now,
            'expired_at' => $expiresAt,
        ]);

        ModelQrCodeDetail::create([
            'qr_id' => $qrCode->id,
            'subject' => $request->subject,
            'group' => $request->group,
            'room' => $request->room,
            'study_time' => $request->time_start_study . ' - ' . $request->time_end_study,
            'note' => $request->note,
            'created_at' => $now,
        ]);

        return $this->showQR();

    }

    public function showQR()
    {
        $user = Auth::user();
        $teacherId = $user->teacher->id;

        $qr = ModelQrCode::where('teacher_id', $teacherId)
            ->where('expired_at', '>', now())
            ->latest()
            ->first();

        if ($qr) {
            $detail = ModelQrCodeDetail::where('qr_id', $qr->id)->first();

            $qrHtml = QrCode::format('svg')->generate($qr->qr_token);

            $qrData = [
                'created_at' => $qr->created_at,
                'expired_at' => $qr->expired_at,
                'duration' => $qr->duration_min,
                'subject' => $detail->subject,
                'group' => $detail->group,
                'room' => $detail->room,
                'study_time' => $detail->study_time,
                'note' => $detail->note,
            ];

            return view('teacher.attendanceqrcode', [
                'qr' => $qrHtml,
                'qrData' => $qrData,
            ]);
        }

        return view('teacher.attendanceqrcode', [
            'qr' => null,
            'qrData' => null,
        ]);
    }

    public function endQR()
    {
        $user = Auth::user();
        $teacherId = $user->teacher->id;

        $qr = ModelQrCode::where('teacher_id', $teacherId)
            ->where('expired_at', '>', now())
            ->latest()
            ->first();

        if (!$qr) {
            return response()->json(['message' => 'No active QR code found.'], 404);
        }

        $now = Carbon::now();
        $createdAt = Carbon::parse($qr->created_at);

        $newDuration = $createdAt->diffInMinutes($now);

        $qr->update([
            'expired_at' => $now,
            'duration_min' => $newDuration,
        ]);

        return view('teacher.attendanceqrcode', [
            'qr' => null,
            'qrData' => null,
        ]);
    }

}
