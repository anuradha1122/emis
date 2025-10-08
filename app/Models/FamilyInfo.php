<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FamilyInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'userId',
        'memberType',
        'nic',
        'name',
        'school',
        'profession',
        'active',
    ];

    public function memberTypeRelation(): BelongsTo
    {
        return $this->belongsTo(FamilyMemberType::class, 'memberType', 'id');
    }
}
