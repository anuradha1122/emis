<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GuardianRelationshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable FK checks → safe truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('guardian_relationships')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            ['id' => 1, 'name' => 'Mother'],
            ['id' => 2, 'name' => 'Father'],
            ['id' => 3, 'name' => 'Grand Mother'],
            ['id' => 4, 'name' => 'Grand Father'],
            ['id' => 5, 'name' => 'Brother'],
            ['id' => 6, 'name' => 'Sister'],
            ['id' => 7, 'name' => 'Other'],
        ];

        DB::table('guardian_relationships')->insert($data);
    }
}
