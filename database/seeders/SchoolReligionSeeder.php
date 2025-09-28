<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SchoolReligionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable FK checks for safe truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('school_religions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            ['id' => 1, 'name' => 'Buddhism'],
            ['id' => 2, 'name' => 'Hindu'],
            ['id' => 3, 'name' => 'Islam'],
            ['id' => 4, 'name' => 'Catholic'],
            ['id' => 5, 'name' => 'Christian'],
            ['id' => 6, 'name' => 'Other'],
        ];

        DB::table('school_religions')->insert($data);
    }
}
