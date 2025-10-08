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
use App\Models\School;

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
    public function currentPrincipalService(): HasOne
{
    return $this->hasOne(UserInService::class, 'userId', 'id')
                ->where('serviceId', 3)
                ->whereNull('releasedDate');
}

public function currentTeacherService(): HasOne
{
    return $this->hasOne(UserInService::class, 'userId', 'id')
                ->where('serviceId', 1)
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

    public function educationQualificationInfos()
    {
        return $this->hasMany(EducationQualificationInfo::class, 'userId')
                    ->where('active', 1)
                    ->with('educationQualification');
    }

    public function professionalQualificationInfos()
    {
        return $this->hasMany(ProfessionalQualificationInfo::class, 'userId')
                    ->where('active', 1)
                    ->with('professionalQualification');
    }

    public function familyInfos()
    {
        return $this->hasMany(FamilyInfo::class, 'userId')
                    ->where('active', 1)
                    ->with('memberTypeRelation');
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
            case 'ministry':
                return School::where('active', 1)->pluck('id')->toArray();
            default:
                return [];
        }
    }

    // === Permission Management ===
    // Relation to Role
    public function role()
    {
        return $this->belongsTo(Role::class, 'roleId'); // assuming 'role_id' is in users table
    }

    // Permissions via role
    public function permissions()
    {
        return $this->role
        ? $this->role->permissions()->where('active', 1)
        : collect();
    }

    // Check if user has a specific permission
    public function hasPermission(string $permissionName): bool
    {
        return $this->permissions()->where('name', $permissionName)->exists();
    }

    // Optional: Check if user has permission by ID
    public function hasPermissionById(int $permissionId): bool
    {
        return $this->permissions()->where('id', $permissionId)->exists();
    }

    // === User Search ===
    public function scopeSearchUsers(Builder $query, $search = null, int $appointmentType = 1, ?int $serviceId = null)
    {
        return $query->with(['personalInfo', 'currentService'])
        ->whereHas('currentService', function ($q) use ($serviceId) {
            if ($serviceId !== null) {
                $q->where('serviceId', $serviceId);
            }
            $q->whereNull('releasedDate'); // only current service
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
