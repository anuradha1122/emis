<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Illness extends Model
{
    use HasFactory;

    protected $table = 'illnesses';

    protected $fillable = ['name', 'description', 'active'];

    public function personalInfos(): HasMany
    {
        return $this->hasMany(PersonalInfo::class, 'illnessId', 'id');
    }
}
