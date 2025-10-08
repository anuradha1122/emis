<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function userService()
    {
        return $this->belongsTo(UserInService::class, 'userServiceId', 'id');
    }

    // School 1 relationship
    public function school1()
    {
        return $this->belongsTo(School::class, 'school1Id', 'id')
                    ->with('workPlace'); // eager load the workPlace
    }

    public function school2()
    {
        return $this->belongsTo(School::class, 'school2Id', 'id')
                    ->with('workPlace');
    }

    public function school3()
    {
        return $this->belongsTo(School::class, 'school3Id', 'id')
                    ->with('workPlace');
    }

    public function school4()
    {
        return $this->belongsTo(School::class, 'school4Id', 'id')
                    ->with('workPlace');
    }

    public function school5()
    {
        return $this->belongsTo(School::class, 'school5Id', 'id')
                    ->with('workPlace');
    }

    // School 1 relationship
    public function alterSchool1()
    {
        return $this->belongsTo(School::class, 'alterSchool1Id', 'id')
                    ->with('workPlace'); // eager load the workPlace
    }

    public function alterSchool2()
    {
        return $this->belongsTo(School::class, 'alterSchool2Id', 'id')
                    ->with('workPlace');
    }

    public function alterSchool3()
    {
        return $this->belongsTo(School::class, 'alterSchool3Id', 'id')
                    ->with('workPlace');
    }

    public function alterSchool4()
    {
        return $this->belongsTo(School::class, 'alterSchool4Id', 'id')
                    ->with('workPlace');
    }

    public function alterSchool5()
    {
        return $this->belongsTo(School::class, 'alterSchool5Id', 'id')
                    ->with('workPlace');
    }

    public function transferType(): BelongsTo
    {
        return $this->belongsTo(TransferType::class, 'typeId');
    }

}
