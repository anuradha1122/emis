<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OfficeType extends Model
{
    protected $fillable = ['name'];

    public function offices(): HasMany
    {
        return $this->hasMany(Office::class, 'officeTypeId', 'id');
    }
}

