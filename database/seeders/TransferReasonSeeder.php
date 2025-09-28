<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransferReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable FK checks → safe truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('transfer_reasons')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = array(
            array('id' => '1','name' => 'No Reason'),
            array('id' => '2','name' => 'Changing the permanent residence'),
            array('id' => '3','name' => 'On medical grounds'),
            array('id' => '4','name' => 'Higher Education Requirements of the children'),
            array('id' => '5','name' => 'Personal Reasons'),
            array('id' => '6','name' => 'Service period was completed')
        );

        DB::table('transfer_reasons')->insert($data);
    }
}
