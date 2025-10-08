<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class GnDivision extends Model
{
    use HasFactory;

    public function locationInfos(): HasMany
    {
        return $this->hasMany(LocationInfo::class, 'gnDivisionId', 'id');
    }

    public function dsDivision(): BelongsTo
    {
        return $this->belongsTo(DsDivision::class, 'dsId');
    }
}
