<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrincipalTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'refferenceNo',
        'userServiceId',
        'appointmentLetterNo',
        'serviceConfirm',
        'schoolDistance',
        'position',
        'specialChildren',
        'expectTransfer',
        'reason',
        'school1Id',
        'distance1',
        'school2Id',
        'distance2',
        'school3Id',
        'distance3',
        'school4Id',
        'distance4',
        'school5Id',
        'distance5',
        'anySchool',
        'mention',
        'active',
    ];

    public function userService()
    {
        return $this->belongsTo(UserInService::class, 'userServiceId', 'id');
    }

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

}
