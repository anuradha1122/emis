<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Get all permission IDs
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('role_permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $allPermissionIds = Permission::pluck('id')->toArray();

        // Prepare role_permissions entries for Super Admin (roleId = 1)
        $rolePermissions = [];
        foreach ($allPermissionIds as $pid) {
            $rolePermissions[] = [
                'roleId' => 1,           // Super Admin
                'permissionId' => $pid,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert into role_permissions table
        DB::table('role_permissions')->insert($rolePermissions);
    }
}