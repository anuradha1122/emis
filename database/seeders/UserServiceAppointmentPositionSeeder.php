<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserServiceAppointmentPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('user_service_appointment_positions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $data = array(
            array('id' => '1','userServiceAppId' => '1','positionId' => '1','positionedDate' => '2024-11-26','releasedDate' => NULL),
            array('id' => '2','userServiceAppId' => '2','positionId' => '1','positionedDate' => '2024-11-26','releasedDate' => NULL)
          );
        DB::table('user_service_appointment_positions')->insert($data);
    }
}
