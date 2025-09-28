<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersonalInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'userId',
        'profilePicture',
        'raceId',
        'religionId',
        'civilStatusId',
        'genderId',
        'birthDay',
        'bloodGroupId',
        'illnessId',
        'active',
    ];

    /**
     * Each personal info belongs to one user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function race(): BelongsTo
    {
        return $this->belongsTo(Race::class, 'raceId', 'id');
    }

    public function religion(): BelongsTo
    {
        return $this->belongsTo(Religion::class, 'religionId', 'id');
    }

    public function civilStatus(): BelongsTo
    {
        return $this->belongsTo(CivilStatus::class, 'civilStatusId', 'id');
    }

    public function bloodGroup(): BelongsTo
    {
        return $this->belongsTo(BloodGroup::class, 'bloodGroupId', 'id');
    }

    public function illness(): BelongsTo
    {
        return $this->belongsTo(Illness::class, 'illnessId', 'id');
    }
}
