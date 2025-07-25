<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'title',
    ];

    /**
     * Get the teacher that owns this position.
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
