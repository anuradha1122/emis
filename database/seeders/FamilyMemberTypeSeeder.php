<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FamilyMemberTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable FK checks for safe truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('family_member_types')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            ['id' => 1, 'name' => 'Wife'],
            ['id' => 2, 'name' => 'husband'],
            ['id' => 3, 'name' => 'Daughter'],
            ['id' => 4, 'name' => 'Son'],
            ['id' => 5, 'name' => 'Father'],
            ['id' => 6, 'name' => 'Mother'],
        ];

        DB::table('family_member_types')->insert($data);
    }
}
