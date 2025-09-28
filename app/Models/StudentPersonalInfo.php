<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPersonalInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'studentId',
        'profilePicture',
        'raceId',
        'religionId',
        'genderId',
        'bloodGroupId',
        'illnessId',
        'birthDay',
        'birthCertificate',
        'birthDsDivisionId',
        'active',
    ];
}
