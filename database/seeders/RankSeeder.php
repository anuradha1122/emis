<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RankSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('ranks')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            
            ['id' => 8, 'name' => 'SLTS 1', 'serviceId' => 1],
            ['id' => 9, 'name' => 'SLTS 2-I', 'serviceId' => 1],
            ['id' => 10, 'name' => 'SLTS 2-II', 'serviceId' => 1],
            ['id' => 11, 'name' => 'SLTS 3-I(A)', 'serviceId' => 1],
            ['id' => 12, 'name' => 'SLTS 3-I(B)', 'serviceId' => 1],
            ['id' => 13, 'name' => 'SLTS 3-I(C)', 'serviceId' => 1],
            ['id' => 14, 'name' => 'SLTS 3-II', 'serviceId' => 1],

            ['id' => 5, 'name' => 'SLPS 1', 'serviceId' => 3],
            ['id' => 6, 'name' => 'SLPS 2', 'serviceId' => 3],
            ['id' => 7, 'name' => 'SLPS 3', 'serviceId' => 3],

            ['id' => 1, 'name' => 'SLEAS I', 'serviceId' => 4],
            ['id' => 2, 'name' => 'SLEAS II', 'serviceId' => 4],
            ['id' => 3, 'name' => 'SLEAS III(General)', 'serviceId' => 4],
            ['id' => 4, 'name' => 'SLEAS III(Special)', 'serviceId' => 4],
        ];

        DB::table('ranks')->insert($data);
    }
}
