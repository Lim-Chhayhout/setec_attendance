<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
    ];

    /**
     * Get the teacher that owns this position.
     */

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_subject_tokens', 'subject_id', 'teacher_id');
    }
}
