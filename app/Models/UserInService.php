<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;

class UserInService extends Model
{
    use HasFactory;

    protected $fillable = [
        'userId', 'serviceId', 'appointedDate', 'releasedDate', 'current'
    ];

    protected static function booted()
    {
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('active', 1);
        });
    }

    /**
     * Scope for current service rows (releasedDate is null).
     */
    public function scopeCurrent(Builder $query): Builder
    {
        return $query->whereNull('releasedDate');
    }

    /**
     * Scope for previous service rows (releasedDate is not null).
     */
    public function scopePrevious(Builder $query): Builder
    {
        return $query->whereNotNull('releasedDate');
    }

    // Relationships ----------------------

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'serviceId', 'id');
    }

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

    public function teacherTransfers()
    {
        return $this->hasMany(TeacherTransfer::class, 'userServiceId', 'id');
    }

    public function teacherService(): HasOne
    {
        return $this->hasOne(TeacherService::class, 'userServiceId', 'id');
    }

    public function principalService(): HasOne
    {
        return $this->hasOne(PrincipalService::class, 'userServiceId', 'id');
    }

    public function serviceInRanks(): HasMany
    {
        return $this->hasMany(UserServiceInRank::class, 'userServiceId', 'id');
    }
}

