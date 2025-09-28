<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SchoolClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks to safely truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('school_classes')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            ['id' => 1, 'name' => 'Grade 1-5'],
            ['id' => 2, 'name' => 'Grade 1-8'],
            ['id' => 3, 'name' => 'Grade 1-11'],
            ['id' => 4, 'name' => 'Grade 1-13'],
            ['id' => 5, 'name' => 'Grade 6-11'],
            ['id' => 6, 'name' => 'Grade 6-13'],
            ['id' => 7, 'name' => 'Other'],
        ];

        DB::table('school_classes')->insert($data);
    }
}
