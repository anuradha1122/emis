<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('contact_infos')->truncate();
        $data = array(
            array('id' => '1','userId' => '1','permAddressLine1' => 'Temple Road','permAddressLine2' => 'Mainnoluwa','permAddressLine3' => 'Warakapola','tempAddressLine1' => NULL,'tempAddressLine2' => NULL,'tempAddressLine3' => NULL,'mobile1' => '0775206113','mobile2' =>'0715194218'),
            array('id' => '2','userId' => '2','permAddressLine1' => 'Suranga','permAddressLine2' => 'Sumangala Mawatha','permAddressLine3' => 'Wariyapola','tempAddressLine1' => NULL,'tempAddressLine2' => NULL,'tempAddressLine3' => NULL,'mobile1' => '0772506113','mobile2' => NULL)
        );
        DB::table('contact_infos')->insert($data);
    }
}
