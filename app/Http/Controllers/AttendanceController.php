<?php

namespace App\Http\Controllers;

use App\Models\Attendance as ModelAttendance;
use App\Models\QrCode as ModelQrCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function scan(Request $request)
    {
        try {
            $request->validate([
                'token' => 'required|string'
            ]);

            $qr = ModelQrCode::with(['teacher', 'qrCodeDetail'])->where('qr_token', $request->token)->first();

            if (!$qr || Carbon::now()->greaterThan($qr->expired_at)) {
                return response()->json(['status' => 'expired']);
            }

            $user = Auth::user();
            if (!$user->student) {
                return response()->json(['status' => 'failed', 'message' => 'Student not found']);
            }

            $studentGroup = $user->student->group->group_name;

            $qrGroup = $qr->qrCodeDetail->group;

            if ($studentGroup !== $qrGroup) {
                return response()->json(['status' => 'error']);
            }

            $studentId = $user->student->id;

            $exists = ModelAttendance::where('qrcode_id', $qr->id)
                ->where('student_id', $studentId)
                ->exists();

            if ($exists) {
                return response()->json(['status' => 'scanned']);
            }

            $attendance = ModelAttendance::create([
                'qrcode_id' => $qr->id,
                'student_id' => $studentId,
                'scanned_at' => now(),
            ]);

            $fullTeacherName = $qr->teacher->first_name . " " . $qr->teacher->last_name;

            return response()->json([
                'status' => 'success',
                'teacher' => $fullTeacherName ?? 'N/A',
                'subject' => $qr->qrCodeDetail->subject ?? '',
                'group' => $qr->qrCodeDetail->group ?? '',
                'room' => $qr->qrCodeDetail->room ?? '',
                'study_time' => $qr->qrCodeDetail->study_time ?? '',
                'status_text' => '✅ Present',
            ]);


        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => $e->getMessage()
            ]);
        }
    }
}
