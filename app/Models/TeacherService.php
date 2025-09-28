<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherService extends Model
{
    use HasFactory;

    protected $fillable = [
        'userServiceId',
        'appointmentSubjectId',
        'mainSubjectId',
        'appointmentMediumId',
        'appointmentCategoryId',
        'active',
    ];
}
