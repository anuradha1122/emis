<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationQualificationInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'userId',
        'educationQualificationId',
        'effectiveDate',
        'description',
        'active',
    ];
}
