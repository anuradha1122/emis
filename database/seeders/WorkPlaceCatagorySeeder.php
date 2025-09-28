<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WorkPlaceCatagorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable FK checks for safe truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('work_place_catagories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            ['id' => 1, 'name' => 'School'],
            ['id' => 2, 'name' => 'office'],
            ['id' => 3, 'name' => 'Ministry'],
            ['id' => 4, 'name' => 'Center'],
        ];

        DB::table('work_place_catagories')->insert($data);
    }
}
