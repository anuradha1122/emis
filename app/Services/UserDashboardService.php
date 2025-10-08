<?php

namespace App\Services;

use App\Models\User;
use App\Models\School;
use Illuminate\Support\Facades\DB;

class UserDashboardService
{

    public function getMainStatsFor(): array
    {
        $national_school_count = School::where('active', 1)
            ->where('authorityId', 1)
            ->count();

        $provincial_school_count = School::where('active', 1)
            ->where('authorityId', 2)
            ->count();

        $sinhala_medium_count = School::where('active', 1)
            ->where('languageId', 1)
            ->count();

        $tamil_medium_count = School::where('active', 1)
            ->where('languageId', 2)
            ->count();

        $counts = DB::table('users')
            ->join('user_in_services', 'users.id', '=', 'user_in_services.userId')
            ->join('user_service_appointments', 'user_in_services.id', '=', 'user_service_appointments.userServiceId')
            ->where('users.active', 1)
            ->whereNull('user_in_services.releasedDate')
            ->whereNull('user_service_appointments.releasedDate')
            ->where('user_service_appointments.appointmentType', 1)
            ->selectRaw('
                SUM(CASE WHEN user_in_services.serviceId = 1 THEN 1 ELSE 0 END) as teacher_service_count,
                SUM(CASE WHEN user_in_services.serviceId = 3 THEN 1 ELSE 0 END) as principal_service_count
            ')
            ->first();

        return [
            'national_school_count' => $national_school_count,
            'provincial_school_count' => $provincial_school_count,
            'sinhala_medium_count' => $sinhala_medium_count,
            'tamil_medium_count' => $tamil_medium_count,
            'teacher_service_count' => $counts->teacher_service_count ?? 0,
            'principal_service_count' => $counts->principal_service_count ?? 0,
        ];
    }



    public function getTeacherStatsFor(User $user): array
    {
        $schoolIds = $user->relatedSchoolIds();
        $counts = DB::table('users')
            ->leftjoin('personal_infos', 'users.id', '=', 'personal_infos.userId')
            ->join('user_in_services', 'users.id', '=', 'user_in_services.userId')
            ->join('user_service_appointments', 'user_in_services.id', '=', 'user_service_appointments.userServiceId')
            ->join('work_places', 'user_service_appointments.workPlaceId', '=', 'work_places.id')
            ->join('schools', 'work_places.id', '=', 'schools.workPlaceId')
            ->whereIn('schools.id', $schoolIds)
            ->where('user_in_services.serviceId', 1)
            ->where('user_in_services.releasedDate', null)
            ->where('user_service_appointments.releasedDate', null)
            ->selectRaw("
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, personal_infos.birthDay, CURDATE()) BETWEEN 18 AND 30 THEN 1 ELSE 0 END) as age_18_30,
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, personal_infos.birthDay, CURDATE()) BETWEEN 31 AND 40 THEN 1 ELSE 0 END) as age_31_40,
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, personal_infos.birthDay, CURDATE()) BETWEEN 41 AND 50 THEN 1 ELSE 0 END) as age_41_50,
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, personal_infos.birthDay, CURDATE()) BETWEEN 51 AND 60 THEN 1 ELSE 0 END) as age_51_60,

                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, user_service_appointments.appointedDate, CURDATE()) <= 3 THEN 1 ELSE 0 END) as appointment_0_3,
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, user_service_appointments.appointedDate, CURDATE()) BETWEEN 4 AND 5 THEN 1 ELSE 0 END) as appointment_4_5,
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, user_service_appointments.appointedDate, CURDATE()) BETWEEN 6 AND 8 THEN 1 ELSE 0 END) as appointment_6_8,
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, user_service_appointments.appointedDate, CURDATE()) BETWEEN 9 AND 10 THEN 1 ELSE 0 END) as appointment_8_10,
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, user_service_appointments.appointedDate, CURDATE()) > 10 THEN 1 ELSE 0 END) as appointment_over_10,

                SUM(CASE WHEN personal_infos.genderId = 1 THEN 1 ELSE 0 END) as male_count,
                SUM(CASE WHEN personal_infos.genderId = 2 THEN 1 ELSE 0 END) as female_count,

                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, user_in_services.appointedDate, CURDATE()) > 30 THEN 1 ELSE 0 END) as service_over_30,
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, user_in_services.appointedDate, CURDATE()) <= 30 THEN 1 ELSE 0 END) as service_under_30
            ")
            ->first();

        return [
            'ageGroups' => [
                '18-30' => $counts->age_18_30,
                '31-40' => $counts->age_31_40,
                '41-50' => $counts->age_41_50,
                '51-60' => $counts->age_51_60,
            ],
            'appointmentPeriods' => [
                '0-3'   => $counts->appointment_0_3,
                '4-5'   => $counts->appointment_4_5,
                '6-8'   => $counts->appointment_6_8,
                '8-10'  => $counts->appointment_8_10,
                '>10'   => $counts->appointment_over_10,
            ],
            'male_count'       => $counts->male_count,
            'female_count'     => $counts->female_count,
            'service_over_30'  => $counts->service_over_30,
            'service_under_30' => $counts->service_under_30,
        ];
    }

    public function getPrincipalStatsFor(User $user): array
    {
        $schoolIds = $user->relatedSchoolIds();
        $counts = DB::table('users')
            ->leftjoin('personal_infos', 'users.id', '=', 'personal_infos.userId')
            ->join('user_in_services', 'users.id', '=', 'user_in_services.userId')
            ->join('user_service_appointments', 'user_in_services.id', '=', 'user_service_appointments.userServiceId')
            ->join('work_places', 'user_service_appointments.workPlaceId', '=', 'work_places.id')
            ->join('schools', 'work_places.id', '=', 'schools.workPlaceId')
            ->whereIn('schools.id', $schoolIds)
            ->where('user_in_services.serviceId', 3) // Assuming 2 is the serviceId for principals
            ->where('user_in_services.releasedDate', null)
            ->where('user_service_appointments.releasedDate', null)
            ->selectRaw("
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, personal_infos.birthDay, CURDATE()) BETWEEN 18 AND 30 THEN 1 ELSE 0 END) as age_18_30,
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, personal_infos.birthDay, CURDATE()) BETWEEN 31 AND 40 THEN 1 ELSE 0 END) as age_31_40,
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, personal_infos.birthDay, CURDATE()) BETWEEN 41 AND 50 THEN 1 ELSE 0 END) as age_41_50,
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, personal_infos.birthDay, CURDATE()) BETWEEN 51 AND 60 THEN 1 ELSE 0 END) as age_51_60,

                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, user_service_appointments.appointedDate, CURDATE()) <= 3 THEN 1 ELSE 0 END) as appointment_0_3,
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, user_service_appointments.appointedDate, CURDATE()) BETWEEN 4 AND 5 THEN 1 ELSE 0 END) as appointment_4_5,
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, user_service_appointments.appointedDate, CURDATE()) BETWEEN 6 AND 8 THEN 1 ELSE 0 END) as appointment_6_8,
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, user_service_appointments.appointedDate, CURDATE()) BETWEEN 9 AND 10 THEN 1 ELSE 0 END) as appointment_8_10,
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, user_service_appointments.appointedDate, CURDATE()) > 10 THEN 1 ELSE 0 END) as appointment_over_10,

                SUM(CASE WHEN personal_infos.genderId = 1 THEN 1 ELSE 0 END) as male_count,
                SUM(CASE WHEN personal_infos.genderId = 2 THEN 1 ELSE 0 END) as female_count,

                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, user_in_services.appointedDate, CURDATE()) > 30 THEN 1 ELSE 0 END) as service_over_30,
                SUM(CASE WHEN TIMESTAMPDIFF(YEAR, user_in_services.appointedDate, CURDATE()) <= 30 THEN 1 ELSE 0 END) as service_under_30
            ")
            ->first();

        return [
            'ageGroups' => [
                '18-30' => $counts->age_18_30,
                '31-40' => $counts->age_31_40,
                '41-50' => $counts->age_41_50,
                '51-60' => $counts->age_51_60,
            ],
            'appointmentPeriods' => [
                '0-3'   => $counts->appointment_0_3,
                '4-5'   => $counts->appointment_4_5,
                '6-8'   => $counts->appointment_6_8,
                '8-10'  => $counts->appointment_8_10,
                '>10'   => $counts->appointment_over_10,
            ],
            'male_count'       => $counts->male_count,
            'female_count'     => $counts->female_count,
            'service_over_30'  => $counts->service_over_30,
            'service_under_30' => $counts->service_under_30,
        ];
    }

    public function getSchoolStatsFor(User $user): array
    {
        $schoolIds = $user->relatedSchoolIds();

        if (count($schoolIds) === 1) {
            $school = DB::table('schools')->where('id', $schoolIds[0])->first();

            return [
                'total'       => 1,
                'card_1_name' => 'School Authority',
                'card_2_name' => 'School Facility Level',
                'card_3_name' => 'School Medium',
                'card_4_name' => 'School Density Category',

                'card_1' => $school->authorityId === 1 ? 'National School' : 'Provincial School',
                'card_2' => match($school->facilityId) {
                    1 => 'More Convenient',
                    2 => 'Convenient',
                    3 => 'Not Convenient',
                    4 => 'Difficult',
                    5 => 'Very Difficult',
                    default => null,
                },
                'card_3' => match($school->languageId) {
                    1 => 'Sinhala',
                    2 => 'Tamil',
                    3 => 'English',
                    default => null,
                },
                'card_4' => match($school->densityId) {
                    1 => '1AB',
                    2 => '1C',
                    3 => 'Type 2',
                    4 => 'Type 3',
                    default => null,
                },
            ];

        } elseif (count($schoolIds) > 1) {
            $schoolCounts = DB::table('schools')
                ->whereIn('schools.id', $schoolIds)
                ->selectRaw("
                    COUNT(*) as total_schools,
                    SUM(CASE WHEN authorityId = 1 THEN 1 ELSE 0 END) as national_schools,
                    SUM(CASE WHEN authorityId = 2 THEN 1 ELSE 0 END) as provincial_schools,
                    SUM(CASE WHEN languageId = 1 THEN 1 ELSE 0 END) as sinhala_schools,
                    SUM(CASE WHEN languageId = 2 THEN 1 ELSE 0 END) as tamil_schools
                ")
                ->first();

            // 🟢 convert stdClass -> array before returning
            return [
                'total'       => $schoolCounts->total_schools,
                'card_1_name' => 'National Schools',
                'card_2_name' => 'Provincial Schools',
                'card_3_name' => 'Sinhala Schools',
                'card_4_name' => 'Tamil Schools',

                'card_1' => $schoolCounts->national_schools,
                'card_2' => $schoolCounts->provincial_schools,
                'card_3' => $schoolCounts->sinhala_schools,
                'card_4' => $schoolCounts->tamil_schools,
            ];
        }

        return []; // fallback if no schools
    }

    public function getSettingsStatsFor(): array
    {
        $permission_count = DB::table('permissions')
        ->where('active', 1)
        ->count();
        $role_count = DB::table('roles')
        ->where('active', 1)
        ->where('status', 1)
        ->count();
        $role_user_count = DB::table('users')
        ->where('active', 1)
        ->where('roleId', '!=', 0)
        ->count();


        return [
            'permission_count' => $permission_count,
            'role_count' => $role_count,
            'role_user_count' => $role_user_count,
        ];
    }




}
