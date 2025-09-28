<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolAuthority extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function schools(): HasMany
    {
        return $this->hasMany(School::class, 'authorityId', 'id');
    }
}
