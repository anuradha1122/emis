<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class District extends Model
{
    protected $fillable = [
        'name',
        'provinceId', // optional, if you have provinces table
    ];

    public function offices(): HasMany
    {
        return $this->hasMany(Office::class, 'districtId', 'id');
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'provinceId', 'id');
    }

    public function zones(): HasMany
    {
        return $this->hasMany(Office::class, 'districtId', 'id')
                    ->where('officeTypeId', 2);
    }


}
