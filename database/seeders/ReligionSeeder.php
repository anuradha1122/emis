<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReligionSeeder extends Seeder
{
    public function run(): void
    {
        // Temporarily disable foreign key checks to allow truncation
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('religions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            ['id' => 1, 'name' => 'Buddhism'],
            ['id' => 2, 'name' => 'Hindu'],
            ['id' => 3, 'name' => 'Islam'],
            ['id' => 4, 'name' => 'Catholic'],
            ['id' => 5, 'name' => 'Christian'],
            ['id' => 6, 'name' => 'Other'],
        ];

        DB::table('religions')->insert($data);
    }
}
