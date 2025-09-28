<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Office extends Model
{
    use HasFactory;

    public function workPlace(): BelongsTo
    {
        return $this->belongsTo(WorkPlace::class, 'workPlaceId', 'id');
    }

    public function officeType(): BelongsTo
    {
        return $this->belongsTo(OfficeType::class, 'officeTypeId', 'id');
    }

    public function schools(): HasMany
    {
        return $this->hasMany(School::class, 'officeId', 'id');
    }

    // 🔹 Self-referencing relationship
    public function higherOffice(): BelongsTo
    {
        return $this->belongsTo(Office::class, 'higherOfficeId', 'id');
    }

    public function subOffices(): HasMany
    {
        return $this->hasMany(Office::class, 'higherOfficeId', 'id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'districtId', 'id');
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'provinceId', 'id');
    }

    public function locationInfos(): HasMany
    {
        return $this->hasMany(LocationInfo::class, 'educationDivisionId', 'id');
    }

    // Get the division office (officeTypeId = 3)
    public function division(): ?Office
    {
        return $this->officeTypeId === 3 ? $this : null;
    }

    public function divisions(): HasMany
    {
        // Only offices under this zone that are divisions (officeTypeId = 3)
        return $this->hasMany(Office::class, 'higherOfficeId', 'id')
                    ->where('officeTypeId', 3);
    }

    // Get the zone office (higher office of division, officeTypeId = 2)
    public function zone(): ?Office
    {
        if ($this->higherOffice && $this->higherOffice->officeTypeId === 2) {
            return $this->higherOffice;
        }

        return null;
    }

    // Get the province office (higher office of zone, officeTypeId = 1)
    public function provinceOffice(): ?Office
    {
        $zone = $this->zone();
        if ($zone && $zone->higherOffice && $zone->higherOffice->officeTypeId === 1) {
            return $zone->higherOffice;
        }

        return null;
    }

}
