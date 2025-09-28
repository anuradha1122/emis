<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CivilStatus extends Model
{
    use HasFactory;

    protected $table = 'civil_statuses';

    protected $fillable = ['name', 'active'];

    public function personalInfos(): HasMany
    {
        return $this->hasMany(PersonalInfo::class, 'civilStatusId', 'id');
    }
}
