<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonalInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('personal_infos')->truncate();
        $data = array(
            array('id' => '1','userId' => '1','raceId' => NULL,'religionId' => NULL,'civilStatusId' => NULL,'genderId' => '1','birthDay' => '1987-08-04'),
            array('id' => '2','userId' => '2','raceId' => NULL,'religionId' => NULL,'civilStatusId' => NULL,'genderId' => '2','birthDay' => '1993-11-22')
        );
        DB::table('personal_infos')->insert($data);
    }
}
