<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClassMediumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Temporarily disable foreign key checks to allow truncation
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('class_media')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            ['id' => 1, 'name' => 'Sinhala'],
            ['id' => 2, 'name' => 'Tamil'],
            ['id' => 3, 'name' => 'English'],
            ['id' => 4, 'name' => 'Sinhala/English'],
            ['id' => 5, 'name' => 'Tamil/English'],
            ['id' => 6, 'name' => 'Sinhala/Tamil'],
            ['id' => 7, 'name' => 'Sinhala/Tamil/English'],
        ];

        DB::table('class_media')->insert($data);
    }
}
