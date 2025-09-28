<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserServiceAppointmentPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'userServiceAppId', 'positionId', 'positionedDate', 'releasedDate', 'current', 'active'
    ];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(UserServiceAppointment::class, 'userServiceAppId', 'id');
    }

    // Optional: if you have a `positions` master table
    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class, 'positionId', 'id');
    }
}
