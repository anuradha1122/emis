<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AppointmentTerminationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable FK checks → safe truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('appointment_terminations')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data = [
            ['id' => 1, 'name' => 'Transfer to another school'],
            ['id' => 2, 'name' => 'Pension'],
            ['id' => 3, 'name' => 'Service Termination'],
            ['id' => 4, 'name' => 'Death'],
        ];

        DB::table('appointment_terminations')->insert($data);
    }
}
