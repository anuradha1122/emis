<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SchoolGenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable FK checks → safe truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('school_genders')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            ['id' => 1, 'name' => 'Boys School'],
            ['id' => 2, 'name' => 'Girls School'],
            ['id' => 3, 'name' => 'Mixed School'],
            ['id' => 4, 'name' => 'Girls School (Except A/L or Primary)'],
            ['id' => 5, 'name' => 'Boys School (Except A/L or Primary)'],
        ];

        DB::table('school_genders')->insert($data);
    }
}
