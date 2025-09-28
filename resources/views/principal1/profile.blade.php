<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumb :list="$option" />
            <div class="isolate bg-white px-6 py-10 sm:py-10 lg:px-8">
                <x-profile-heading heading="{{ $principal->nameWithInitials }}" subHeading="{{ $principal->nic }}" />
                <div class="border-t border-gray-200">
                    @livewire('principal-profile',
                    [
                        'id' => $principal->id,
                        'name' => $principal->userName,
                        'nameWithInitials' => $principal->nameWithInitials,
                        'nic' => $principal->nic,
                        'race' => $principal->race,
                        'religion' => $principal->religion,
                        'civilStatus' => $principal->civilStatus,
                        'birthDay' => $principal->birthDay,
                        'gender' => $principal->gender,
                        'permAddressLine1' => $principal->permAddressLine1,
                        'permAddressLine2' => $principal->permAddressLine2,
                        'permAddressLine3' => $principal->permAddressLine3,
                        'tempAddressLine1' => $principal->tempAddressLine1,
                        'tempAddressLine2' => $principal->tempAddressLine2,
                        'tempAddressLine3' => $principal->tempAddressLine3,
                        'mobile1' => $principal->mobile1,
                        'mobile2' => $principal->mobile2,
                        'service' => $service,
                        'appointment' => $appointment,
                        'position' => $position,
                    ])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>