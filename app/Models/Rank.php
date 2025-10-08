<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Rank extends Model
{
    use HasFactory;

    public function userServiceInRanks(): HasMany
    {
        return $this->hasMany(UserServiceInRank::class, 'rankId', 'id');
    }
}
