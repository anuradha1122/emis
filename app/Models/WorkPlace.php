<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class WorkPlace extends Model
{
    protected $fillable = ['name', 'categoryId', 'censusNo', 'incrementId'];

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

    public function contactInfo()
    {
        return $this->hasOne(WorkPlaceContactInfo::class, 'workPlaceId');
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

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
            ->orWhere('censusNo', 'like', "%{$term}%");
        });
    }

}
