<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /**
     * All user service appointments related to this service.
     */
    public function userInServices(): HasMany
    {
        return $this->hasMany(UserInService::class, 'serviceId', 'id');
    }

    /**
     * Scope for only active services.
     */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
