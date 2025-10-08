<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\User;

class PrincipalFullReportExport implements FromCollection
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
            'currentPrincipalService.currentAppointment.workPlace.school',
        ])
        ->get()
        ->map(function($principal) {
            return [
                'NIC' => $principal->nic ?? '',
                'Principal Name' => $principal->nameWithInitials ?? '',
                'School' => $principal->currentPrincipalService?->currentAppointment?->workPlace?->name ?? '',
                'Gender' => $principal->personalInfo?->genderId == 1
                            ? 'Male'
                            : ($principal->personalInfo?->genderId == 2 ? 'Female' : 'N/A'),
                'Race' => $principal->personalInfo?->race?->name ?? '',
                'Religion' => $principal->personalInfo?->religion?->name ?? '',
                'Civil Status' => $principal->personalInfo?->civilStatus?->name ?? '',
                'Birth Day' => $principal->personalInfo?->birthDay ?? '',
                'Service Appointed Date' => $principal->currentPrincipalService?->appointedDate ?? '',
                'School Appointed Date' => $principal->currentPrincipalService?->currentAppointment?->appointedDate ?? '',
            ];
        });
    }
}
