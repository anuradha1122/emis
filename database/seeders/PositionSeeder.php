<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('positions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        $data = [
            // School Positions (workPlaceCatagoryId = 1)
            ['id' => 1, 'name' => 'School Regular', 'workPlaceCatagoryId' => 1],
            ['id' => 2, 'name' => 'School Data Officer', 'workPlaceCatagoryId' => 1],
            ['id' => 3, 'name' => 'School Administrator', 'workPlaceCatagoryId' => 1],

            // Division and Zone Positions (workPlaceCatagoryId = 2)
            ['id' => 4, 'name' => 'Division Data Officer', 'workPlaceCatagoryId' => 2],
            ['id' => 5, 'name' => 'Division Administrator', 'workPlaceCatagoryId' => 2],
            ['id' => 6, 'name' => 'Zonal Data Officer', 'workPlaceCatagoryId' => 2],
            ['id' => 7, 'name' => 'Zone Personal File Officer', 'workPlaceCatagoryId' => 2],
            ['id' => 8, 'name' => 'Zone Account Handling Officer', 'workPlaceCatagoryId' => 2],
            ['id' => 9, 'name' => 'Zone Planing Officer', 'workPlaceCatagoryId' => 2],
            ['id' => 10, 'name' => 'Zone Personal File Administrator', 'workPlaceCatagoryId' => 2],
            ['id' => 11, 'name' => 'Zone Account Handling Administrator', 'workPlaceCatagoryId' => 2],
            ['id' => 12, 'name' => 'Zone Planing Administrator', 'workPlaceCatagoryId' => 2],
            ['id' => 13, 'name' => 'Zone Regular', 'workPlaceCatagoryId' => 2],
            ['id' => 14, 'name' => 'Zone Administrator', 'workPlaceCatagoryId' => 2],

            // Provincial Positions (workPlaceCatagoryId = 2)
            ['id' => 15, 'name' => 'Provincial Data Officer', 'workPlaceCatagoryId' => 2],
            ['id' => 16, 'name' => 'Provincial Personal File Officer', 'workPlaceCatagoryId' => 2],
            ['id' => 17, 'name' => 'Provincial Account Handling Officer', 'workPlaceCatagoryId' => 2],
            ['id' => 18, 'name' => 'Provincial Planing Officer', 'workPlaceCatagoryId' => 2],
            ['id' => 19, 'name' => 'Provincial Personal File Administrator', 'workPlaceCatagoryId' => 2],
            ['id' => 20, 'name' => 'Provincial Account Handling Administrator', 'workPlaceCatagoryId' => 2],
            ['id' => 21, 'name' => 'Provincial Planing Administrator', 'workPlaceCatagoryId' => 2],
            ['id' => 22, 'name' => 'Provincial Regular', 'workPlaceCatagoryId' => 2],
            ['id' => 23, 'name' => 'Provincial Administrator', 'workPlaceCatagoryId' => 2],

            // Ministry Positions (workPlaceCatagoryId = 3)
            ['id' => 24, 'name' => 'Ministry Data Officer', 'workPlaceCatagoryId' => 3],
            ['id' => 25, 'name' => 'Ministry Administrator', 'workPlaceCatagoryId' => 3],

            // Education Center Positions (workPlaceCatagoryId = 4)
            ['id' => 26, 'name' => 'Education Center(IT) Data Officer', 'workPlaceCatagoryId' => 4],
            ['id' => 27, 'name' => 'Education Center(Training) Officer', 'workPlaceCatagoryId' => 4],
            ['id' => 28, 'name' => 'Education Center Administrator', 'workPlaceCatagoryId' => 4],
        ];

        DB::table('positions')->insert($data);
    }
}
