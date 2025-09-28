<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ministry extends Model
{
    protected $fillable = [
        'workPlaceId',
        'officeId',
        // other ministry fields
    ];

    public function workPlace(): BelongsTo
    {
        return $this->belongsTo(WorkPlace::class, 'workPlaceId', 'id');
    }

    public function office(): BelongsTo
    {
        return $this->belongsTo(Office::class, 'officeId', 'id');
    }
}
