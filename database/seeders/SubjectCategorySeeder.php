<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SubjectCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('subject_categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        

        $data = [
            ['id' => 1, 'name' => 'Primary'],
            ['id' => 2, 'name' => 'O/L Main Subjects'],
            ['id' => 3, 'name' => 'O/L First Category Subjects'],
            ['id' => 4, 'name' => 'O/L Second Category Subjects'],
            ['id' => 5, 'name' => 'O/L Third Category Subjects'],
            ['id' => 6, 'name' => 'O/L Religion Subjects'],
            ['id' => 7, 'name' => 'O/L Other Subjects'],
            ['id' => 8, 'name' => 'A/L Science Subjects'],
            ['id' => 9, 'name' => 'A/L Arts Subjects'],
            ['id' => 10, 'name' => 'A/L Commerce Subjects'],
            ['id' => 11, 'name' => 'A/L technology Subjects'],
            ['id' => 12, 'name' => 'A/L Other Main Subjects'],
            ['id' => 13, 'name' => 'A/L Other Sub Subjects'],
            ['id' => 14, 'name' => '13 Years Education Subjects'],
        ];

        DB::table('subject_categories')->insert($data);
    }
}
