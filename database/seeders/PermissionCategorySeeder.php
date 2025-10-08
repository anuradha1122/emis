<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable FK checks → safe truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permission_categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = array(
            array('id' => '1','name' => 'Settings','active' => 1),
            array('id' => '2','name' => 'Schools','active' => 1),
            array('id' => '3','name' => 'Office','active' => 1),
            array('id' => '4','name' => 'Teacher','active' => 1),
            array('id' => '5','name' => 'Principal','active' => 1),
            array('id' => '6','name' => 'SLEAS','active' => 1),
            array('id' => '7','name' => 'My','active' => 1),
        );

        DB::table('permission_categories')->insert($data);
    }
}
