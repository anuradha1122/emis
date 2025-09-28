<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserInServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('user_in_services')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = array(
            array('id' => '1','userId' => '1','serviceId' => '1','appointedDate' => '2024-11-26','releasedDate' => NULL),
            array('id' => '2','userId' => '2','serviceId' => '1','appointedDate' => '2024-11-26','releasedDate' => NULL)
        );

        DB::table('user_in_services')->insert($data);
    }
}
