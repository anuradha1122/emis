<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SchoolFacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks to safely truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('school_facilities')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            ['id' => 1, 'name' => 'More Convenient'],
            ['id' => 2, 'name' => 'Convenient'],
            ['id' => 3, 'name' => 'Not Convenient'],
            ['id' => 4, 'name' => 'Difficult'],
            ['id' => 5, 'name' => 'Very Difficult'],
        ];

        DB::table('school_facilities')->insert($data);
    }
}
