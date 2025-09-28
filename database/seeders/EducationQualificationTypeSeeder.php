<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EducationQualificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable FK checks, truncate table, then re-enable
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('education_qualification_types')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Prepare data with UUIDs
        $data = [

            ['id' => 1, 'name' => 'No Degree'],
            ['id' => 2, 'name' => 'Undergraduate Degrees'],
            ['id' => 3, 'name' => 'Graduate Degrees'],
            ['id' => 4, 'name' => 'Postgraduate and Doctoral Degrees'],
            ['id' => 5, 'name' => 'Specialized/Professional Degrees'],
        ];

        DB::table('education_qualification_types')->insert($data);
    }
}
