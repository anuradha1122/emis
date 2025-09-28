<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $permissions = [
            ['name' => 'my_profile', 'description' => 'Access to My Profile'],
            ['name' => 'my_appointment', 'description' => 'Access to My Appointment'],
            ['name' => 'slts_side_tab', 'description' => 'Access to SLTS side tab'],
            ['name' => 'slps_side_tab', 'description' => 'Access to SLPS side tab'],
            ['name' => 'sleas_side_tab', 'description' => 'Access to SLEAS side tab'],
            ['name' => 'non_academic_side_tab', 'description' => 'Access to Non-Academic side tab'],
            ['name' => 'accountant_side_tab', 'description' => 'Access to Accountant side tab'],
            ['name' => 'student_side_tab', 'description' => 'Access to Student side tab'],
            ['name' => 'settings', 'description' => 'All Admin Controlls'],
        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']], // prevent duplicates
                ['description' => $permission['description']]
            );
        }
    }
}
