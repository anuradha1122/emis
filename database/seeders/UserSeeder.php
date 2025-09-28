<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $data = array(
            array('id' => '1','name' => 'Anuradha ruwan Pathirana','nameWithInitials' => 'K.P.A.R. Pathirana','email' => 'anuradharuwan@gmail.com','nic' => '872170260V','password' => '$2y$12$wFOjhnpHc8B8pK8Sl953EeCmpHzDJV47Tb1ndPXIuo9UYAa0ezHH2'),
            array('id' => '2','name' => 'Herath Mudhiyanselage Amani Sewwandi Herath','nameWithInitials' => 'H.M.A.S. Herath','email' => 'herathamani@gmail.com','nic' => '938263456V','password' => '$2y$12$wh.0UG56QoStSsSi1Oq/leUnVfyiTg.1NBzndYiyMO.VhUufL.YGi')
        );
        DB::table('users')->insert($data);
    }
}
