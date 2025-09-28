<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSchool extends Model
{
    use HasFactory;

    protected $fillable = [
        'studentId',
        'schoolId',
        'appointedDate',
        'releasedDate',
        'current',
        'active',
    ];
}
