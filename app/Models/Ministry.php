<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Ministry extends Model
{
    use HasFactory;

    protected $fillable = [
        'incrementId',
        'workPlaceIncrementId',
        'workPlaceId',
        'officeIncrementId',
        'officeId',
        'ministryNo',
        // other ministry fields
    ];

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
}
