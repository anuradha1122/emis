<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable FK checks → safe truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('grades')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        

        $data = array(
            array('id' => '1','name' => 'Grade 1'),
            array('id' => '2','name' => 'Grade 2'),
            array('id' => '3','name' => 'Grade 3'),
            array('id' => '4','name' => 'Grade 4'),
            array('id' => '5','name' => 'Grade 5'),
            array('id' => '6','name' => 'Grade 6'),
            array('id' => '7','name' => 'Grade 7'),
            array('id' => '8','name' => 'Grade 8'),
            array('id' => '9','name' => 'Grade 9'),
            array('id' => '10','name' => 'Grade 10'),
            array('id' => '11','name' => 'Grade 11'),
            array('id' => '12','name' => 'Grade 12'),
            array('id' => '13','name' => 'Grade 13'),
            array('id' => '14','name' => 'Special'),
        );

        DB::table('grades')->insert($data);
    }
}
