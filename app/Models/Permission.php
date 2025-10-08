<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'permissions';

    protected $fillable = [
        'name',
        'description',
        'categoryId',
        'active',
    ];

    /**
     * Get the category this permission belongs to.
     */
    public function category()
    {
        return $this->belongsTo(PermissionCategory::class, 'categoryId');
    }

    public function positions()
    {
        return $this->belongsToMany(
            Position::class,
            'position_permissions',
            'permissionId', // foreign key on pivot table for this model
            'positionId'    // foreign key on pivot table for related model
        );
    }



    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

}
