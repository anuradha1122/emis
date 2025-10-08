<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use HasFactory;

    public function appointmentServices(): HasMany
    {
        return $this->hasMany(TeacherService::class, 'appointmentSubjectId', 'id');
    }

    public function mainServices(): HasMany
    {
        return $this->hasMany(TeacherService::class, 'mainSubjectId', 'id');
    }
}
