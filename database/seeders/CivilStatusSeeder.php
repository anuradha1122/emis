<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CivilStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Temporarily disable foreign key checks to allow truncation
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('civil_statuses')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            ['id' => 1, 'name' => 'Married'],
            ['id' => 2, 'name' => 'Single'],
            ['id' => 3, 'name' => 'Divorced'],
            ['id' => 4, 'name' => 'Rev'],
            ['id' => 5, 'name' => 'Other'],
        ];

        DB::table('civil_statuses')->insert($data);
    }
}
