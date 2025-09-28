<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentContactInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'studentId',
        'addressLine1',
        'addressLine2',
        'addressLine3',
        'mobile',
        'motherName',
        'motherNic',
        'motherMobile',
        'motherEmail',
        'fatherName',
        'fatherNic',
        'fatherMobile',
        'fatherEmail',
        'guardianName',
        'guardianNic',
        'guardianRelationshipId',
        'guardianMobile',
        'guardianEmail',
        'active',
    ];

}
