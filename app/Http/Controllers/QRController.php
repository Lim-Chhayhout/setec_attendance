<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRController extends Controller
{   
    public function showQR()
    {
        $qrSession = session('qr_session');

        if (!$qrSession) {
            return view('teacher.attendanceqrcode');
        }

        if (Carbon::now()->timestamp >= $qrSession['expires_at']) {
            session()->forget('qr_session');
            return view('teacher.attendanceqrcode');
        }

        return view('teacher.attendanceqrcode', $qrSession);
    }

    public function generatePost(Request $request){

        $created_at = Carbon::now();
        $created_at_format = Carbon::now()->format('l, F j, Y \a\t g:i:s A');
        $subject = $request->input('subject');
        $group = $request->input('group');
        $room = $request->input('room');
        $note = $request->input('note', null);
        $time_start_study = $request->input('time_start_study');
        $time_end_study = $request->input('time_end_study');
        $duration = (int) $request->input('duration');

        $user = Auth::user();
        $teacherId = $user->teacher->id;

        $gen_at = Carbon::now();
        $expires_at = $gen_at->copy()->addMinutes($duration);

        $qrToken = Str::random(10);


        $qrData = json_encode([
            'created_at' => $created_at,
            'created_at_format' => $created_at_format,
            'subject' => $subject,
            'group' => $group,
            'room' => $room,
            'note' => $note,
            'time_start_study' => $time_start_study,
            'time_end_study' => $time_end_study,
            'duration' => $duration,
            'teacherId' => $teacherId,
            'qrToken' => $qrToken,
            'expires_at' => $expires_at->toIso8601String(),
        ]);

        $qr = QrCode::format('svg')->generate($qrData);

        session([
            'qr_session' => [
                'qr' => $qr,
                'created_at' => $created_at,
                'created_at_format' => $created_at_format,
                'subject' => $subject,
                'group' => $group,
                'room' => $room,
                'note' => $note,
                'time_start_study' => $time_start_study,
                'time_end_study' => $time_end_study,
                'duration' => $duration,
                'teacherId' => $teacherId,
                'qrToken' => $qrToken,
                'expires_at' => $expires_at->timestamp
            ]
        ]);

        return redirect()->route('qr.page'); 

    }
}
