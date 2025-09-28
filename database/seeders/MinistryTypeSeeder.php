<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MinistryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable FK checks for safe truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('ministry_types')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            ['id' => 1, 'name' => 'Provincial Ministry', 'level' => 2],
            ['id' => 2, 'name' => 'Main Ministry', 'level' => 1],
        ];

        DB::table('ministry_types')->insert($data);
    }
}
