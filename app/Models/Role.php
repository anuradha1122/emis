<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Permission;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'status',
        'active',
    ];

    /**
     * The attributes that should be cast to native types.
     */
    protected $casts = [
        'status' => 'boolean',
        'active' => 'boolean',
    ];

    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'role_permissions',
            'roleId',       // foreign key on role_permissions for this role
            'permissionId'  // foreign key on role_permissions for permission
        );
    }
}

