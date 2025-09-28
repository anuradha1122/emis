<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
