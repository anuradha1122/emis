<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class teacherTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'refferenceNo',
        'userServiceId',
        'typeId',
        'reasonId',
        'school1Id',
        'school2Id',
        'school3Id',
        'school4Id',
        'school5Id',
        'anySchool',
        'gradeId',
        'alterSchool1Id',
        'alterSchool2Id',
        'alterSchool3Id',
        'alterSchool4Id',
        'alterSchool5Id',
        'extraCurricular',
        'mention',
        'active',
    ];

    // One UserInService has many TeacherTransfers
    public function teacherTransfers()
    {
        return $this->hasMany(TeacherTransfer::class, 'userId', 'id');
    }
}
