<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class UserInService extends Model
{
    use HasFactory;

    protected $fillable = [
        'userId', 'serviceId', 'appointedDate', 'releasedDate', 'current'
    ];

    /**
     * Scope for current service rows (releasedDate is null).
     */
    public function scopeCurrent(Builder $query): Builder
    {
        return $query->whereNull('releasedDate');
    }

    /**
     * The user who owns this service record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    /**
     * (Optional) Relation to Service model if you have services table.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'serviceId', 'id');
    }

    /**
     * Has many appointments.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(UserServiceAppointment::class, 'userServiceId', 'id');
    }

    public function currentAppointment($type = 1)
    {
        return $this->hasOne(UserServiceAppointment::class, 'userServiceId')
            ->whereNull('releasedDate')
            ->where('active', 1)
            ->when($type, fn($q) => $q->where('appointmentType', $type));
    }

    // One UserInService has many TeacherTransfers
    public function teacherTransfers()
    {
        return $this->hasMany(TeacherTransfer::class, 'userId', 'id');
    }
}
