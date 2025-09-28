<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OccupationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('office_types')->truncate();

        $data = [
            ['id' => 1, 'name' => 'Provincial Department', 'level' => 1],
            ['id' => 2, 'name' => 'Zonal Office', 'level' => 2],
            ['id' => 3, 'name' => 'Divisional Office', 'level' => 3],
        ];

        DB::table('office_types')->insert($data);
    }
}
