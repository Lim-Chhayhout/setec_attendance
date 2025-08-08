<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherGroupTk extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'group_id',
    ];

    /**
     * Get the teacher that owns this position.
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

}
