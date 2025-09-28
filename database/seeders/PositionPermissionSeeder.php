<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('position_permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            ['positionId' => 1, 'permissionId' => 1],
            ['positionId' => 1, 'permissionId' => 2],
            ['positionId' => 1, 'permissionId' => 3],
            ['positionId' => 1, 'permissionId' => 4],
            ['positionId' => 1, 'permissionId' => 5],
            ['positionId' => 1, 'permissionId' => 6],
            ['positionId' => 1, 'permissionId' => 7],
            ['positionId' => 1, 'permissionId' => 9],
            ['positionId' => 2, 'permissionId' => 1],
            ['positionId' => 2, 'permissionId' => 3],
            ['positionId' => 3, 'permissionId' => 1],
            ['positionId' => 3, 'permissionId' => 4],
            ['positionId' => 4, 'permissionId' => 1],
            ['positionId' => 4, 'permissionId' => 5],
            ['positionId' => 5, 'permissionId' => 1],
            ['positionId' => 5, 'permissionId' => 6],
            ['positionId' => 6, 'permissionId' => 1],
            ['positionId' => 6, 'permissionId' => 7],
        ];
        DB::table('position_permissions')->insert($data);
    }
}
