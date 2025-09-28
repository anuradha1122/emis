<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SchoolSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Temporarily disable foreign key checks to allow truncation
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('school_sections')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = array(
            array('id' => '1','name' => 'Primary'),
            array('id' => '2','name' => 'Secondary'),
            array('id' => '3','name' => 'Art'),
            array('id' => '4','name' => 'Commerce'),
            array('id' => '5','name' => 'Science'),
            array('id' => '6','name' => 'Technology'),
            array('id' => '7','name' => '13 Years'),
            array('id' => '8','name' => 'Special Education'),
        );

        DB::table('school_sections')->insert($data);
    }
}
