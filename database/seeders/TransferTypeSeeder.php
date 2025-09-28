<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransferTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable FK checks → safe truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('transfer_types')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = array(
            array('id' => '1','name' => 'within zone'),
            array('id' => '2','name' => 'another zone'),
            array('id' => '3','name' => 'another province'),
            array('id' => '4','name' => 'national school')
        );

        DB::table('transfer_types')->insert($data);
    }
}
