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
            ['name' => 'settings', 'categoryId' => 1, 'description' => 'All Admin Controlls'],

            ['name' => 'my_profile', 'categoryId' => 7, 'description' => 'My Profile'],

            ['name' => 'slts_dashboard', 'categoryId' => 4, 'description' => 'SLTS dashboard'],
            ['name' => 'slts_register', 'categoryId' => 4, 'description' => 'SLTS Registration'],
            ['name' => 'slts_search', 'categoryId' => 4, 'description' => 'SLTS Search'],
            ['name' => 'slts_report_list', 'categoryId' => 4, 'description' => 'SLTS Report List'],
            ['name' => 'slts_full_report', 'categoryId' => 4, 'description' => 'SLTS Full Report'],
            ['name' => 'slts_full_report_pdf', 'categoryId' => 4, 'description' => 'SLTS Full Report PDF'],
            ['name' => 'slts_profile', 'categoryId' => 4, 'description' => 'SLTS Profile'],
            ['name' => 'slts_profile_edit', 'categoryId' => 4, 'description' => 'SLTS Profile Edit'],
            ['name' => 'slts_personal_edit', 'categoryId' => 4, 'description' => 'SLTS user profile Main Info Edit'],
            ['name' => 'slts_personal_info_edit', 'categoryId' => 4, 'description' => 'SLTS user personal Info Edit'],
            ['name' => 'slts_location_edit', 'categoryId' => 4, 'description' => 'SLTS user location Info Edit'],
            ['name' => 'slts_rank_edit', 'categoryId' => 4, 'description' => 'SLTS user Rank Info Edit'],
            ['name' => 'slts_family_edit', 'categoryId' => 4, 'description' => 'SLTS user family Info Edit'],
            ['name' => 'slts_education_edit', 'categoryId' => 4, 'description' => 'SLTS user education Info Edit'],
            ['name' => 'slts_professional_edit', 'categoryId' => 4, 'description' => 'SLTS user professional Info Edit'],
            ['name' => 'slts_service_edit', 'categoryId' => 4, 'description' => 'SLTS user service Info Edit'],
            ['name' => 'slts_appointment_edit', 'categoryId' => 4, 'description' => 'SLTS user appointment Info Edit'],
            ['name' => 'slts_position_edit', 'categoryId' => 4, 'description' => 'SLTS user position Info Edit'],
            ['name' => 'slps_dashboard', 'categoryId' => 5, 'description' => 'SLPS dashboard'],
            ['name' => 'slps_register', 'categoryId' => 5, 'description' => 'SLPS Registration'],
            ['name' => 'slps_search', 'categoryId' => 5, 'description' => 'SLPS Search'],
            ['name' => 'slps_report_list', 'categoryId' => 5, 'description' => 'SLPS Report List'],
            ['name' => 'slps_full_report', 'categoryId' => 5, 'description' => 'SLPS Full Report'],
            ['name' => 'slps_full_report_pdf', 'categoryId' => 5, 'description' => 'SLPS Full Report PDF'],
            ['name' => 'slps_profile', 'categoryId' => 4, 'description' => 'SLPS Profile'],
            ['name' => 'slps_profile_edit', 'categoryId' => 4, 'description' => 'SLPS Profile Edit'],
            ['name' => 'slps_personal_edit', 'categoryId' => 5, 'description' => 'SLPS user profile Main Info Edit'],
            ['name' => 'slps_personal_info_edit', 'categoryId' => 5, 'description' => 'SLPS user personal Info Edit'],
            ['name' => 'slps_location_edit', 'categoryId' => 5, 'description' => 'SLPS user location Info Edit'],
            ['name' => 'slps_rank_edit', 'categoryId' => 5, 'description' => 'SLPS user Rank Info Edit'],
            ['name' => 'slps_family_edit', 'categoryId' => 5, 'description' => 'SLPS user family Info Edit'],
            ['name' => 'slps_education_edit', 'categoryId' => 5, 'description' => 'SLPS user education Info Edit'],
            ['name' => 'slps_professional_edit', 'categoryId' => 5, 'description' => 'SLPS user professional Info Edit'],
            ['name' => 'slps_service_edit', 'categoryId' => 5, 'description' => 'SLPS user service Info Edit'],
            ['name' => 'slps_appointment_edit', 'categoryId' => 4, 'description' => 'SLPS user appointment Info Edit'],
            ['name' => 'slps_position_edit', 'categoryId' => 4, 'description' => 'SLPS user position Info Edit'],

            ['name' => 'school_dashboard', 'categoryId' => 2, 'description' => 'School dashboard'],
            ['name' => 'school_register', 'categoryId' => 2, 'description' => 'School Registration'],
            ['name' => 'school_search', 'categoryId' => 2, 'description' => 'School Search'],
            ['name' => 'school_report_list', 'categoryId' => 2, 'description' => 'School Report List'],
            ['name' => 'school_full_report', 'categoryId' => 2, 'description' => 'School Full Report'],

            ['name' => 'settings_general', 'categoryId' => 1, 'description' => 'General Settings'],
            ['name' => 'settings_profile', 'categoryId' => 1, 'description' => "Admin's Profile Settings"],
        ];


        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']], // prevent duplicates
                ['categoryId' => $permission['categoryId']],
                ['description' => $permission['description']]
            );
        }
    }
}
