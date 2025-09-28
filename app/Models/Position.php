<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    use HasFactory;

    /**
     * All appointment-positions linked to this position.
     */
    public function appointmentPositions(): HasMany
    {
        return $this->hasMany(UserServiceAppointmentPosition::class, 'positionId', 'id');
    }

    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'position_permissions',
            'positionId', // foreign key on pivot table for this model
            'permissionId' // foreign key on pivot table for related model
        );
    }
}
