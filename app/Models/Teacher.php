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

    public function qrCodes()
    {
        return $this->hasMany(QrCode::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'teacher_group_tokens', 'teacher_id', 'group_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_subject_tokens', 'teacher_id', 'subject_id');
    }

}
