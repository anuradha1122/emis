<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProfessionalQualificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Temporarily disable foreign key checks to allow truncation
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('professional_qualification_types')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $data = [
            ['name' => 'Foundational Teacher Qualifications'],
            ['name' => 'Undergraduate-Level Qualifications'],
            ['name' => 'Postgraduate Diplomas'],
            ['name' => 'Master\'s Degrees'],
            ['name' => 'Doctoral-Level Qualifications'],
            ['name' => 'Specializations in Education'],
            ['name' => 'Leadership and Administration'],
            ['name' => 'Psychology and Counseling'],
            ['name' => 'Language and TESOL Qualifications'],
            ['name' => 'Modern and Digital Teaching'],
            ['name' => 'Curriculum and Assessment'],
        ];

        DB::table('professional_qualification_types')->insert($data);
    }
}
