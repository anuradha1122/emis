<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RaceSeeder extends Seeder
{
    public function run(): void
    {
        // Temporarily disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('races')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            ['id' => 1, 'name' => 'Sinhala'],
            ['id' => 2, 'name' => 'Srilanka Tamil'],
            ['id' => 3, 'name' => 'Indian Tamil'],
            ['id' => 4, 'name' => 'Muslim'],
            ['id' => 5, 'name' => 'Other'],
        ];

        DB::table('races')->insert($data);
    }
}
