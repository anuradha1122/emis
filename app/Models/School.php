<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'workPlaceId',
        'officeId',
        'authorityId',
        'ethnicityId',
        'languageId',
        'classId',
        'densityId',
        'genderId',
        'facilityId',
        'religionId',
        // other school fields...
    ];

    public function workPlace(): BelongsTo
    {
        return $this->belongsTo(WorkPlace::class, 'workPlaceId', 'id');
    }

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class, 'officeId', 'id');
    }

    public function authority(): BelongsTo
    {
        return $this->belongsTo(SchoolAuthority::class, 'authorityId', 'id');
    }

    public function ethnicity(): BelongsTo
    {
        return $this->belongsTo(SchoolEthnicity::class, 'ethnicityId', 'id');
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(SchoolLanguage::class, 'languageId', 'id');
    }

    public function classType(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class, 'classId', 'id');
    }

    public function density(): BelongsTo
    {
        return $this->belongsTo(SchoolDensity::class, 'densityId', 'id');
    }

    public function gender(): BelongsTo
    {
        return $this->belongsTo(SchoolGender::class, 'genderId', 'id');
    }

    public function facility(): BelongsTo
    {
        return $this->belongsTo(SchoolFacility::class, 'facilityId', 'id');
    }

    public function religion(): BelongsTo
    {
        return $this->belongsTo(SchoolReligion::class, 'religionId', 'id');
    }
}
