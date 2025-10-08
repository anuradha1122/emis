<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionCategory extends Model
{
    /** @use HasFactory<\Database\Factories\PermissionCategoryFactory> */
    use HasFactory;

    protected $table = 'permission_categories';

    protected $fillable = [
        'name',
        'active',
    ];

    /**
     * Get all permissions that belong to this category.
     */
    public function permissions()
    {
        return $this->hasMany(Permission::class, 'categoryId');
    }
}
