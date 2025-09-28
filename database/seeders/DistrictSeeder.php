<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('districts')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = array(
            array('id' => '1','name' => 'Nuwara Eliya','provinceId' => '5'),
            array('id' => '2','name' => 'Matale','provinceId' => '5'),
            array('id' => '3','name' => 'Kandy','provinceId' => '5'),
            array('id' => '4','name' => 'Trincomalee','provinceId' => '8'),
            array('id' => '5','name' => 'Batticaloa','provinceId' => '8'),
            array('id' => '6','name' => 'Polonnaruwa','provinceId' => '4'),
            array('id' => '7','name' => 'Anuradhapura','provinceId' => '4'),
            array('id' => '8','name' => 'Puttalam','provinceId' => '3'),
            array('id' => '9','name' => 'Kurunegala','provinceId' => '3'),
            array('id' => '10','name' => 'Vavuniya','provinceId' => '1'),
            array('id' => '11','name' => 'Mulattivu','provinceId' => '1'),
            array('id' => '12','name' => 'Mannar','provinceId' => '1'),
            array('id' => '13','name' => 'Killinochchi','provinceId' => '1'),
            array('id' => '14','name' => 'Jaffna','provinceId' => '1'),
            array('id' => '15','name' => 'Rathnapura','provinceId' => '2'),
            array('id' => '16','name' => 'Kegalle','provinceId' => '2'),
            array('id' => '17','name' => 'Matara','provinceId' => '6'),
            array('id' => '18','name' => 'Hambantota','provinceId' => '6'),
            array('id' => '19','name' => 'Galle','provinceId' => '6'),
            array('id' => '20','name' => 'Badulla','provinceId' => '9'),
            array('id' => '21','name' => 'Kalutara','provinceId' => '7'),
            array('id' => '22','name' => 'Gampaha','provinceId' => '7'),
            array('id' => '23','name' => 'Colombo','provinceId' => '7'),
            array('id' => '24','name' => 'Moneragala','provinceId' => '9'),
            array('id' => '25','name' => 'Ampara','provinceId' => '8')
        );

        DB::table('districts')->insert($data);
    }
}
