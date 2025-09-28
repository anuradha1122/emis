<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentLocationInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'studentId',
        'educationDivisionId',
        'gnDivisionId',
        'active',
    ];
}
