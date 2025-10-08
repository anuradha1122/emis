<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\TeacherTransfer;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TeacherTransferReportExport implements FromCollection, WithHeadings
{
    protected $transferIds;

    public function __construct(array $transferIds)
    {
        $this->transferIds = $transferIds;
    }

    public function collection()
    {
        return TeacherTransfer::whereIn('id', $this->transferIds)
            ->with([
                'transferType',
                'userService.user.personalInfo.race',
                'userService.user.personalInfo.religion',
                'userService.user.personalInfo.civilStatus',
                'userService.currentAppointment.workPlace.school',
                'userService.teacherService.appointmentSubject',
                'userService.teacherService.mainSubject',
            ])
            ->get()
            ->map(function($transfer) {
                $user = $transfer->userService?->user;
                $personalInfo = $user?->personalInfo;
                $school = $transfer->userService?->currentAppointment?->workPlace;
                $school1Name = $transfer->school1?->workPlace?->name ?? '';
                $school2Name = $transfer->school2?->workPlace?->name ?? '';
                $school3Name = $transfer->school3?->workPlace?->name ?? '';
                $school4Name = $transfer->school4?->workPlace?->name ?? '';
                $school5Name = $transfer->school5?->workPlace?->name ?? '';
                $alterSchool1Name = $transfer->alterSchool1?->workPlace?->name ?? '';
                $alterSchool2Name = $transfer->alterSchool2?->workPlace?->name ?? '';
                $alterSchool3Name = $transfer->alterSchool3?->workPlace?->name ?? '';
                $alterSchool4Name = $transfer->alterSchool4?->workPlace?->name ?? '';
                $alterSchool5Name = $transfer->alterSchool5?->workPlace?->name ?? '';
                return [
                    'NIC' => $user?->nic ?? '',
                    'Teacher Name' => $user?->nameWithInitials ?? '',
                    'School' => $school?->name ?? '',
                    'Gender' => $personalInfo?->genderId == 1
                                ? 'Male'
                                : ($personalInfo?->genderId == 2 ? 'Female' : 'N/A'),
                    'Race' => $personalInfo?->race?->name ?? '',
                    'Religion' => $personalInfo?->religion?->name ?? '',
                    'Civil Status' => $personalInfo?->civilStatus?->name ?? '',
                    'Birth Day' => $personalInfo?->birthDay ?? '',
                    'Service Appointed Date' => $transfer->userService?->appointedDate ?? '',
                    'School Appointed Date' => $transfer->userService?->currentAppointment?->appointedDate ?? '',
                    'Transfer Type' => $transfer->transferType?->name ?? 'N/A',
                    'Appointment Subject' => $transfer->userService?->teacherService?->appointmentSubject->name?? '',
                    'Main Subject' => $transfer->userService?->teacherService?->mainSubject->name?? '',
                    'Expected School 1' => $school1Name,
                    'Expected School 2' => $school2Name,
                    'Expected School 3' => $school3Name,
                    'Expected School 4' => $school4Name,
                    'Expected School 5' => $school5Name,
                    'Expected Alter School 1' => $alterSchool1Name,
                    'Expected Alter School 2' => $alterSchool2Name,
                    'Expected Alter School 3' => $alterSchool3Name,
                    'Expected Alter School 4' => $alterSchool4Name,
                    'Expected Alter School 5' => $alterSchool5Name,
                    'Any School' => $transfer?->anyschool == 1
                                ? 'Yes'
                                : ($transfer?->anyschool == 2 ? 'No' : 'N/A'),
                    'Extra Curricular Activities' => $transfer?->extraCurricular ?? '',
                    'Mentions' => $transfer?->mention ?? '',
                    'Principal Approval' => match ($transfer?->principalReason) {
                    1 => 'This teacher can be released without a successor as he/she is an excess teacher.',
                    2 => 'This teacher can be released only if a suitable successor is provided.',
                    3 => 'This teacher can be released without a successor.',
                    4 => 'This teacher can’t be released.',
                    default => 'N/A',
                    },
                    // ✅ Zonal decisions
                    'Zonal Decision 1' => match ($transfer?->zonalReason1) {
                        1 => 'The service of this teacher has been confirmed.',
                        2 => 'The service of this teacher has not been confirmed.',
                        default => 'N/A',
                    },
                    'Zonal Decision 2' => match ($transfer?->zonalReason2) {
                        1 => 'There are disciplinary or audit queries against this teacher.',
                        2 => 'There aren’t disciplinary or audit queries against this teacher.',
                        default => 'N/A',
                    },
                    'Zonal Decision 3' => match ($transfer?->zonalReason3) {
                        1 => 'This teacher is qualified for the transfer (Completed minimum years / Application is complete / Not teaching in non-transferable grades).',
                        2 => 'This teacher isn’t qualified for the transfer (Not completed minimum years / Application incomplete / Teaching in non-transferable grades).',
                        default => 'N/A',
                    },
                    'Zonal Decision 4' => match ($transfer?->zonalReason4) {
                        1 => 'This teacher can be released with a successor.',
                        2 => 'This teacher can be released without a successor.',
                        3 => 'This transfer was rejected (due to insufficient service period or other).',
                        default => 'N/A',
                    },
                ];
            });
            
    }

    // ✅ Add custom column headings
    public function headings(): array
    {
        return [
            'NIC',
            'Teacher Name',
            'School',
            'Gender',
            'Race',
            'Religion',
            'Civil Status',
            'Birth Day',
            'Service Appointed Date',
            'School Appointed Date',
            'Transfer Type',
            'Appointment Subject',
            'Main Subject',
            'Expected School 1',
            'Expected School 2',
            'Expected School 3',
            'Expected School 4',
            'Expected School 5',
            'Expected Alter School 1',
            'Expected Alter School 2',
            'Expected Alter School 3',
            'Expected Alter School 4',
            'Expected Alter School 5',
            'Any School',
            'Extra Curricular Activities',
            'Mentions',
            'Principal Approval',
            'Zonal Decision 1',
            'Zonal Decision 2',
            'Zonal Decision 3',
            'Zonal Decision 4',
            //'Provincial Decision 1',
        ];
    }
}
