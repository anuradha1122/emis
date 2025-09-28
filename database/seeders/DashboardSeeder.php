<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DashboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable FK checks for safe truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('dashboards')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            ['id' => 1, 'name' => 'School Level 1 Dashboard'],
            ['id' => 2, 'name' => 'School Level 2 Dashboard'],
            ['id' => 3, 'name' => 'School Level 3 Dashboard'],
            ['id' => 4, 'name' => 'Division Level 1 Dashboard'],
            ['id' => 5, 'name' => 'Division Level 2 Dashboard'],
            ['id' => 6, 'name' => 'Zonal Level 1 Dashboard'],
            ['id' => 7, 'name' => 'Zonal Level 2 Dashboard'],
            ['id' => 8, 'name' => 'Zonal Level 3 Dashboard'],
            ['id' => 9, 'name' => 'Zonal Level 4 Dashboard'],
            ['id' => 10, 'name' => 'Zonal Level 5 Dashboard'],
            ['id' => 11, 'name' => 'Zonal Level 6 Dashboard'],
            ['id' => 12, 'name' => 'Provincial Level 1 Dashboard'],
            ['id' => 13, 'name' => 'Provincial Level 2 Dashboard'],
            ['id' => 14, 'name' => 'Provincial Level 3 Dashboard'],
            ['id' => 15, 'name' => 'Provincial Level 4 Dashboard'],
            ['id' => 16, 'name' => 'Provincial Level 5 Dashboard'],
            ['id' => 17, 'name' => 'Provincial Level 6 Dashboard'],
            ['id' => 18, 'name' => 'Provincial Level 7 Dashboard'],
            ['id' => 19, 'name' => 'Provincial Level 8 Dashboard'],
            ['id' => 20, 'name' => 'National Level 1 Dashboard'],
            ['id' => 21, 'name' => 'National Level 2 Dashboard'],
            ['id' => 22, 'name' => 'National Level 3 Dashboard'],
        ];

        DB::table('dashboards')->insert($data);
    }
}
