<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BloodGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable FK checks → safe truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('blood_groups')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        

        $data = [
            ['id' => 1, 'name' => 'A+'],
            ['id' => 2, 'name' => 'A-'],
            ['id' => 3, 'name' => 'B+'],
            ['id' => 4, 'name' => 'B-'],
            ['id' => 5, 'name' => 'AB+'],
            ['id' => 6, 'name' => 'AB-'],
            ['id' => 7, 'name' => 'O+'],
            ['id' => 8, 'name' => 'O-'],
        ];

        DB::table('blood_groups')->insert($data);
    }
}
