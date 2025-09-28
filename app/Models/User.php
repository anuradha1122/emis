<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use App\Models\UserInService;
use App\Models\Position;
use App\Models\PersonalInfo;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'nameWithInitials', 'nic', 'email', 'password'
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed'
    ];

    // === Relationships ===

    // User.php
    /**
     * All services (historical + current) for this user.
     */
    public function services(): HasMany
    {
        return $this->hasMany(UserInService::class, 'userId', 'id');
    }

    /**
     * The *current* service for this user (releasedDate is null).
     * Use ->currentService to get the model or use relation for queries/eager loading.
     */
    public function currentService($serviceId = null): HasOne
    {
        $relation = $this->hasOne(UserInService::class, 'userId', 'id')
                        ->whereNull('releasedDate');

        if ($serviceId !== null) {
            $relation->where('serviceId', $serviceId);
        }

        return $relation;
    }

    /**
     * The *current* teacher service for this user (serviceId = 1 and releasedDate is null).
     * Use ->currentTeacherService to get the model or use relation for queries/eager loading.
     */
    public function currentTeacherService(): HasOne
    {
        return $this->hasOne(UserInService::class, 'userId', 'id')
            ->where('serviceId', 1)   // teacher service only
            ->whereNull('releasedDate');
    }


    /**
     * One-to-one relation with PersonalInfo.
     */
    public function personalInfo(): HasOne
    {
        return $this->hasOne(PersonalInfo::class, 'userId', 'id');
    }

    public function contactInfo(): HasOne
    {
        return $this->hasOne(ContactInfo::class, 'userId', 'id');
    }

    public function locationInfo(): HasOne
    {
        return $this->hasOne(LocationInfo::class, 'userId', 'id');
    }

    public function workPlaceType()
    {
        $workplace = auth()->user()->currentService?->currentAppointment?->workPlace;
        if (!$workplace) {
            return null;
        }
        if ($workplace->school) {
            return 'school';
        }
        if ($workplace->office) {
            switch ($workplace->office->officeTypeId) {
                case 1: return 'provincial_department';
                case 2: return 'zone';
                case 3: return 'division';
            }
        }
        if ($workplace->ministry) {
            return 'ministry';
        }

        return 'other';
    }

    public function relatedSchoolIds(): array
    {
        $appointment = $this->currentService?->currentAppointment;
        $workPlace = $appointment?->workPlace;

        if (! $workPlace) {
            return [];
        }

        switch ($this->workPlaceType()) {
            case 'school':
                return [$workPlace->school->id];

            case 'division':
                return $workPlace->office->schools->pluck('id')->toArray();

            case 'zone':
                return $workPlace->office
                    ->subOffices // divisions
                    ->flatMap(fn($division) => $division->schools)
                    ->pluck('id')
                    ->toArray();

            case 'provincial_department':
                return $workPlace->office
                    ->subOffices // zones
                    ->flatMap(fn($zone) => $zone->subOffices) // divisions
                    ->flatMap(fn($division) => $division->schools)
                    ->pluck('id')
                    ->toArray();

            default:
                return [];
        }
    }

    // === Permission Management ===
    public function permissions()
    {
        $positionId = $this->currentService?->currentAppointment?->currentPosition?->positionId;
        if (!$positionId) return collect();
        return Position::find($positionId)?->permissions ?? collect();
    }

    public function hasPermission($permissionName)
    {
        return $this->permissions()->contains('name', $permissionName);
    }

    // === User Search ===
    public function scopeSearchUsers(Builder $query, $search = null, int $type = 1)
    {
        return $query->with(['personalInfo', 'currentTeacherService.currentAppointment'])
            ->whereHas('currentTeacherService', function ($q) use ($type) {
                $q->whereHas('currentAppointment', function ($q2) use ($type) {
                    $q2->where('appointmentType', $type);
                });
            })
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('nic', 'LIKE', "%{$search}%")
                        ->orWhere('nameWithInitials', 'LIKE', "%{$search}%");
                });
            });
    }


}
