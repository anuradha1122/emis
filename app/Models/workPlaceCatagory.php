<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class workPlaceCatagory extends Model
{
    use HasFactory;

    public function workPlaces(): HasMany
    {
        return $this->hasMany(WorkPlace::class, 'catagoryId', 'id');
    }
}
