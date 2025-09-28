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

}
