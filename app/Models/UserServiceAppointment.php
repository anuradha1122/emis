<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserServiceAppointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'userServiceId', 'workPlaceId', 'appointedDate', 'releasedDate',
        'reason', 'appointmentType', 'current'
    ];

    /**
     * Belongs to a UserInService record.
     */
    public function userInService(): BelongsTo
    {
        return $this->belongsTo(UserInService::class, 'userServiceId', 'id');
    }

    public function positions(): HasMany
    {
        return $this->hasMany(UserServiceAppointmentPosition::class, 'userServiceAppId', 'id');
    }

    public function workPlace()
    {
        return $this->belongsTo(WorkPlace::class, 'workPlaceId');
    }

    public function currentWorkPlace()
    {
        return $this->hasOne(WorkPlace::class, 'workPlaceId')
            ->where('active', 1);
    }

    public function currentPosition()
    {
        return $this->hasOne(UserServiceAppointmentPosition::class, 'userServiceAppId')
            ->where('current', 1)
            ->where('active', 1);
    }

}
