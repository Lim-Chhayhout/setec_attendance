<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_name',
        'shift',
        'program',
    ];

    // Example: relationship if users or students belong to group
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
