<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolLanguage extends Model
{
    protected $fillable = ['name'];

    public function schools(): HasMany
    {
        return $this->hasMany(School::class, 'languageId', 'id');
    }
}

