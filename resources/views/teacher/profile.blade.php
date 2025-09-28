<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumb :list="$option" />
            <div class="isolate bg-white px-6 py-10 sm:py-10 lg:px-8">
                <x-profile-heading heading="{{ $teacher->nameWithInitials }}" subHeading="{{ $teacher->nic }}" image="{{ $teacher->profilePicture }}" />
                <div class="border-t border-gray-200">

                    @livewire('teacher-profile', [
                        'teacher' => $teacher,
                        'currentService' => $currentServiceArray,
                        'previousServices' => $previousServicesArray,
                        'currentServiceRanks' => $currentServiceRanksArray,
                        'previousServiceRanks' => $previousServiceRanksArray,
                        'currentAppointments' => $currentAppointments,
                        'previousAppointments' => $previousAppointments,
                        'currentAttachAppointments' => $currentAttachAppointments,
                        'previousAttachAppointments' => $previousAttachAppointments,
                        'currentPositions' => $currentPositions,
                        'previousPositions' => $previousPositions,
                        'currentAttachPositions' => $currentAttachPositions,
                        'previousAttachPositions' => $previousAttachPositions,
                        'educationQualifications' => $educationQualifications,
                        'professionalQualifications' => $professionalQualifications,
                        'family' => $family,
                    ])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
