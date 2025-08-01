<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrCodeDetail extends Model
{
    use HasFactory;

    protected $table = 'qr_code_details';

    public $timestamps = false;

    protected $fillable = [
        'qr_id',
        'subject',
        'group',
        'room',
        'study_time',
        'note',
    ];

    public function qrCode()
    {
        return $this->belongsTo(QrCode::class, 'qr_id');
    }
}
