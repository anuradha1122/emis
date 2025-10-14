<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserInService;

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
            array('userIncrementId' => '1','serviceId' => '1','appointedDate' => '2024-11-26','releasedDate' => NULL),
            array('userIncrementId' => '2','serviceId' => '1','appointedDate' => '2024-11-26','releasedDate' => NULL)
        );

        foreach ($data as $item) {
            // find WorkPlace by incrementId
            $user = User::where('incrementId', $item['userIncrementId'])->first();
            //dd($workPlace->id, $item);
            if ($user) {
                $item['userId'] = $user->id; // assign UUID foreign key
            } else {
                continue; // skip if not found
            }
            //dump($item);
            UserInService::create($item);
        }

        //DB::table('user_in_services')->insert($data);
    }
}
