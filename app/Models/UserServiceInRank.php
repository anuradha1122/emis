<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class UserServiceInRank extends Model
{
    use HasFactory;

    protected $fillable = [
        'userServiceId',
        'rankId',
        'rankedDate',
        'current',
        'active',
    ];

    public function userInService(): BelongsTo
    {
        return $this->belongsTo(UserInService::class, 'userServiceId', 'id');
    }

    public function rank(): BelongsTo
    {
        return $this->belongsTo(Rank::class, 'rankId', 'id');
    }
}
