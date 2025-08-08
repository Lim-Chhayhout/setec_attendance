<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'qrcode_id',
        'student_id',
        'scanned_at',
    ];

    public function qr()
    {
        return $this->belongsTo(QrCode::class, 'qr_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
