<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Religion extends Model
{
    use HasFactory;

    protected $table = 'religions';

    protected $fillable = ['name', 'active'];

    public function personalInfos(): HasMany
    {
        return $this->hasMany(PersonalInfo::class, 'religionId', 'id');
    }
}
