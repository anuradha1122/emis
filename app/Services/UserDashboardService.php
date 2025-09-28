<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserDashboardService
{

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


}
