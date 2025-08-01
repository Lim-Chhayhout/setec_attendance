<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'province',
        'full_address',
        'phone',
        'image',
    ];

    /**
     * The user that this teacher belongs to.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The positions that belong to this teacher.
     */
    public function positions()
    {
        return $this->hasMany(TeacherPosition::class);
    }

    public function qrCodes()
    {
        return $this->hasMany(QrCode::class);
    }
}
