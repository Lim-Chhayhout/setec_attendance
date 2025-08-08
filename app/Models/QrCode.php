<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    use HasFactory;

    protected $table = 'qr_codes';

    public $timestamps = false;

    protected $fillable = [
        'qr_token',
        'ip_address',
        'teacher_id',
        'duration_min',
        'created_at',
        'expired_at',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function qrCodeDetail()
    {
        return $this->hasOne(QrCodeDetail::class, 'qr_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'qr_id');
    }

}
