<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'incrementId',
        'workPlaceIncrementId',
        'workPlaceId',
        'officeIncrementId',
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

    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function booted()
    {
        static::creating(function ($model) {
            // UUID primary key
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }

            // Auto-increment incrementId
            if (empty($model->incrementId)) {
                $max = static::max('incrementId') ?? 0;
                $model->incrementId = $max + 1;
            }
        });
    }

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
