<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FamilyMemberType extends Model
{
    use HasFactory;

    use HasFactory;

    protected $fillable = [
        'name',    // e.g., 'Father', 'Mother', 'Sibling', etc.
        'active',  // 1 = active, 0 = inactive
    ];

    /**
     * Get all family info entries that belong to this member type.
     */
    public function familyInfos(): HasMany
    {
        return $this->hasMany(FamilyInfo::class, 'memberType', 'id');
    }
}
