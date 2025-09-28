<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkPlace extends Model
{
    use HasFactory;

    /**
     * All appointments in this workplace.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(UserServiceAppointment::class, 'workPlaceId', 'id');
    }

    public function catagory(): BelongsTo
    {
        return $this->belongsTo(WorkPlaceCatagory::class, 'catagoryId', 'id');
    }

    public function school(): HasOne
    {
        return $this->hasOne(School::class, 'workPlaceId', 'id');
    }

    public function office(): HasOne
    {
        return $this->hasOne(Office::class, 'workPlaceId', 'id');
    }

    public function ministry(): HasOne
    {
        return $this->hasOne(Ministry::class, 'workPlaceId', 'id');
    }

    /**
     * Shortcut: get the actual detail model depending on category
     */
    public function detail()
    {
        return match ($this->catagoryId) {
            1 => $this->school(),
            2 => $this->office(),
            3 => $this->ministry(),
            default => null,
        };
    }

}
