<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\PrincipalTransfer;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PrincipalTransferReportExport implements FromCollection, WithHeadings
{
    protected $transferIds;

    public function __construct(array $transferIds)
    {
        $this->transferIds = $transferIds;
    }

    public function collection()
    {
        return PrincipalTransfer::whereIn('id', $this->transferIds)
            ->with([
                'userService.user.personalInfo.race',
                'userService.user.personalInfo.religion',
                'userService.user.personalInfo.civilStatus',
                'userService.currentAppointment.workPlace.school',
            ])
            ->get()
            ->map(function($transfer) {
                $user = $transfer->userService?->user;
                $personalInfo = $user?->personalInfo;
                $school = $transfer->userService?->currentAppointment?->workPlace;
                //dd($transfer->school1);
                $school1Name = $transfer->school1?->workPlace?->name ?? '';
                $school2Name = $transfer->school2?->workPlace?->name ?? '';
                $school3Name = $transfer->school3?->workPlace?->name ?? '';
                $school4Name = $transfer->school4?->workPlace?->name ?? '';
                $school5Name = $transfer->school5?->workPlace?->name ?? '';
                return [
                    'NIC' => $user?->nic ?? '',
                    'Appointment Letter No' => $transfer->appointmentLetterNo ?? '',
                    'Service Confirmed' => $transfer?->serviceConfirm == 1
                                ? 'Yes'
                                : ($transfer?->serviceConfirm == 2 ? 'No' : 'N/A'),
                    'Principal Name' => $user?->nameWithInitials ?? '',
                    'School' => $school?->name ?? '',
                    'Gender' => $personalInfo?->genderId == 1
                                ? 'Male'
                                : ($personalInfo?->genderId == 2 ? 'Female' : 'N/A'),
                    // 'Race' => $personalInfo?->race?->name ?? '',
                    // 'Religion' => $personalInfo?->religion?->name ?? '',
                    // 'Civil Status' => $personalInfo?->civilStatus?->name ?? '',
                    'Birth Day' => $personalInfo?->birthDay ?? '',
                    'Service Appointed Date' => $transfer->userService?->appointedDate ?? '',
                    'School Appointed Date' => $transfer->userService?->currentAppointment?->appointedDate ?? '',
                    'Expected School 1' => $school1Name,
                    'Distance For School 1' => $transfer->distance1 ?? '',
                    'Expected School 2' => $school2Name,
                    'Distance For School 2' => $transfer->distance2 ?? '',
                    'Expected School 3' => $school3Name,
                    'Distance For School 3' => $transfer->distance3 ?? '',
                    'Expected School 4' => $school4Name,
                    'Distance For School 4' => $transfer->distance4 ?? '',
                    'Expected School 5' => $school5Name,
                    'Distance For School 5' => $transfer->distance5 ?? '',
                    'Special Children' => $transfer?->specialChildren == 1
                                ? 'Yes'
                                : ($transfer?->specialChildren == 2 ? 'No' : 'N/A'),
                    'Any School' => $transfer?->anySchool == 1
                                ? 'Yes'
                                : ($transfer?->anySchool == 2 ? 'No' : 'N/A'),
                    'Reasons' => $transfer?->reason ?? '',
                    'Mentions' => $transfer?->mention ?? '',
                    // ✅ Zonal decisions
                    'Zonal Decision 1' => match ($transfer?->zonalReason1) {
                        1 => 'The service of this principal has been confirmed.',
                        2 => 'The service of this principal has not been confirmed.',
                        default => 'N/A',
                    },
                    'Zonal Decision 2' => match ($transfer?->zonalReason2) {
                        1 => 'There are disciplinary or audit queries against this principal.',
                        2 => 'There aren’t disciplinary or audit queries against this principal.',
                        default => 'N/A',
                    },
                    'Zonal Decision 3' => match ($transfer?->zonalReason3) {
                        1 => 'This principal is qualified for the transfer (Completed minimum years / Application is complete / Not teaching in non-transferable grades).',
                        2 => 'This principal isn’t qualified for the transfer (Not completed minimum years / Application incomplete / Teaching in non-transferable grades).',
                        default => 'N/A',
                    },
                    'Zonal Decision 4' => match ($transfer?->zonalReason4) {
                        1 => 'This principal can be released with a successor.',
                        2 => 'This principal can be released without a successor.',
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
            'Appointment Letter No',
            'Service Confirmed',
            'Principal Name',
            'School',
            'Gender',
            'Birth Day',
            'Service Appointed Date',
            'School Appointed Date',
            'Expected School 1',
            'Distance For School 1',
            'Expected School 2',
            'Distance For School 2',
            'Expected School 3',
            'Distance For School 3',
            'Expected School 4',
            'Distance For School 4',
            'Expected School 5',
            'Distance For School 5',
            'Special Children',
            'Any School',
            'Reasons',
            'Mentions',
            'Zonal Decision 1',
            'Zonal Decision 2',
            'Zonal Decision 3',
            'Zonal Decision 4',
            //'Provincial Decision 1',
        ];
    }
}
