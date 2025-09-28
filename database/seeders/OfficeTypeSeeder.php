<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OfficeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable FK checks for safe truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('office_types')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            ['id' => 1, 'name' => 'Provincial Department', 'level' => 1],
            ['id' => 2, 'name' => 'Zonal Office', 'level' => 2],
            ['id' => 3, 'name' => 'Divisional Office', 'level' => 3],
        ];

        DB::table('office_types')->insert($data);
    }
}
