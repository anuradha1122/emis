<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BloodGroup extends Model
{
    use HasFactory;

    protected $table = 'blood_groups';

    protected $fillable = ['name', 'active'];

    public function personalInfos(): HasMany
    {
        return $this->hasMany(PersonalInfo::class, 'bloodGroupId', 'id');
    }
}
