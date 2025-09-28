<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\User;

class TeacherFullReportExport implements FromCollection
{
    protected $userIds;

    public function __construct(array $userIds)
    {
        $this->userIds = $userIds;
    }

    public function collection()
    {
        return User::whereIn('id', $this->userIds)
        ->with([
            'personalInfo.race',
            'personalInfo.religion',
            'personalInfo.civilStatus',
            'currentTeacherService.currentAppointment.workPlace.school',
        ])
        ->get()
        ->map(function($teacher) {
            return [
                'NIC' => $teacher->nic ?? '',
                'Teacher Name' => $teacher->nameWithInitials ?? '',
                'School' => $teacher->currentTeacherService?->currentAppointment?->workPlace?->name ?? '',
                'Gender' => $teacher->personalInfo?->genderId == 1
                            ? 'Male'
                            : ($teacher->personalInfo?->genderId == 2 ? 'Female' : 'N/A'),
                'Race' => $teacher->personalInfo?->race?->name ?? '',
                'Religion' => $teacher->personalInfo?->religion?->name ?? '',
                'Civil Status' => $teacher->personalInfo?->civilStatus?->name ?? '',
                'Birth Day' => $teacher->personalInfo?->birthDay ?? '',
                'Service Appointed Date' => $teacher->currentTeacherService?->appointedDate ?? '',
                'School Appointed Date' => $teacher->currentTeacherService?->currentAppointment?->appointedDate ?? '',
            ];
        });
    }
}
