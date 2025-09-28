<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SchoolDensitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks to safely truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('school_densities')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            ['id' => 1, 'name' => '1AB'],
            ['id' => 2, 'name' => '1C'],
            ['id' => 3, 'name' => 'Type 2'],
            ['id' => 4, 'name' => 'Type 3'],
        ];

        DB::table('school_densities')->insert($data);
    }
}
