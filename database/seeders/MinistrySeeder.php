<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Office;
use App\Models\WorkPlace;
use App\Models\Ministry;

class MinistrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable FK checks, truncate table, re-enable checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('ministries')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = array(
            array('workPlaceIncrementId' => '1','officeIncrementId' => NULL,'ministryNo' => 'M1'),
            array('workPlaceIncrementId' => '2','officeIncrementId' => '1','ministryNo' => 'M2'),
            array('workPlaceIncrementId' => '3','officeIncrementId' => '2','ministryNo' => 'M3'),
            array('workPlaceIncrementId' => '4','officeIncrementId' => '3','ministryNo' => 'M4'),
            array('workPlaceIncrementId' => '5','officeIncrementId' => '4','ministryNo' => 'M5'),
            array('workPlaceIncrementId' => '6','officeIncrementId' => '5','ministryNo' => 'M6'),
            array('workPlaceIncrementId' => '7','officeIncrementId' => '6','ministryNo' => 'M7'),
            array('workPlaceIncrementId' => '8','officeIncrementId' => '7','ministryNo' => 'M8'),
            array('workPlaceIncrementId' => '9','officeIncrementId' => '8','ministryNo' => 'M9'),
            array('workPlaceIncrementId' => '10','officeIncrementId' => '9','ministryNo' => 'M10')
        );

        foreach ($data as $item) {
            //dd($item);
            // find WorkPlace by incrementId
            $workPlace = WorkPlace::where('incrementId', $item['workPlaceIncrementId'])->first();
            //dd($workPlace->id, $item);
            if ($workPlace) {
                $item['workPlaceId'] = $workPlace->id; // assign UUID foreign key
                $office = Office::where('incrementId', $item['officeIncrementId'])->first();
                if ($office) {
                    $item['officeId'] = $office->id; // assign UUID foreign key
                } else {
                    $item['officeId'] = null; // assign null if not found
                }
            } else {
                continue; // skip if not found
            }
            //dd($item);
            Ministry::create($item);
        }


    }
}
