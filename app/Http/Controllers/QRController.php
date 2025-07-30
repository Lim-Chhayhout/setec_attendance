<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRController extends Controller
{
    public function generatePost(Request $request){

        $created_at = Carbon::now()->format('l, F j, Y \a\t g:i:s A');

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

        return view('teacher.attendanceqrcode', [
            'qr' => $qr,
            'created_at' => $created_at,
            'subject' => $subject,
            'group' => $group,
            'room' => $room,
            'note' => $note,
            'time_start_study' => $time_start_study,
            'time_end_study' => $time_end_study,
            'duration' => $duration,
            'teacherId' => $teacherId,
            'qrToken' => $qrToken,
        ]);

    }
}
