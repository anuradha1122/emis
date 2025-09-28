<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumb :list="$option" />
            <div class="isolate bg-white px-6 py-10 sm:py-10 lg:px-8">
                <x-profile-heading heading="{{ $teacher->nameWithInitials }}" subHeading="{{ $teacher->nic }}" />
                <div class="border-t border-gray-200">
                    @livewire('teacher-profile',
                    [
                        'id' => $teacher->id,
                        'name' => $teacher->userName,
                        'nameWithInitials' => $teacher->nameWithInitials,
                        'nic' => $teacher->nic,
                        'race' => $teacher->race,
                        'religion' => $teacher->religion,
                        'civilStatus' => $teacher->civilStatus,
                        'birthDay' => $teacher->birthDay,
                        'gender' => $teacher->gender,
                        'permAddressLine1' => $teacher->permAddressLine1,
                        'permAddressLine2' => $teacher->permAddressLine2,
                        'permAddressLine3' => $teacher->permAddressLine3,
                        'tempAddressLine1' => $teacher->tempAddressLine1,
                        'tempAddressLine2' => $teacher->tempAddressLine2,
                        'tempAddressLine3' => $teacher->tempAddressLine3,
                        'mobile1' => $teacher->mobile1,
                        'mobile2' => $teacher->mobile2,
                        'service' => $service,
                        'appointment' => $appointment,
                        'position' => $position,
                    ])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>