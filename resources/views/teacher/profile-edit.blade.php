<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 dark:text-gray-500 leading-tight">
            {{ __('Teacher Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="mx-auto sm:px-6 lg:px-8">
            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto">
                <div class="mb-6">
                    <!-- Breadcrumb -->
                    <x-breadcrumb :items="[
                        'Home' => route('dashboard'),
                        'Teacher Dashboard' => route('teacher.dashboard'),
                        'Teacher Profile' => route('teacher.profile', ['id' => $encryptedId]),
                        'Edit' => null
                    ]" />
                </div>

                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100"></h2>
                    <p class="text-gray-600 dark:text-gray-300">Manage View SLTS(Sri Lanka Teacher Service)
                    </p>
                </div>
                @if (session('success'))
                    <div class="mb-4 p-4 text-green-800 bg-green-100 dark:bg-green-700 dark:text-green-100 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="mt-8 border-t border-gray-200 dark:border-gray-700">
                    @if($section === 'personal')
                    <form method="POST" action="{{ route('teacher.profileupdate') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $decryptedId }}">
                        <input type="hidden" name="section" value="personal">
                        <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-6">
                        {{-- Full Name, Email, NIC (users table) --}}
                            <x-form-text-input-section
                            size="sm:col-span-3"
                            name="name"
                            id="name"
                            label="Full Name"
                            value="{{ old('name', $teacher->name) }}" />

                            <x-form-text-input-section
                            size="sm:col-span-3"
                            name="email"
                            id="email"
                            label="Email"
                            value="{{ old('email', $teacher->email) }}" />

                            <x-form-text-input-section
                            size="sm:col-span-3"
                            name="nic"
                            id="nic"
                            label="NIC"
                            value="{{ old('nic', $teacher->nic) }}" />

                            {{-- Date of Birth (personal_infos table) --}}
                            <x-form-text-input-section
                            size="sm:col-span-3"
                            name="birthDay"
                            id="birthDay"
                            label="Date of Birth"
                            type="date"
                            value="{{ old('birthDay', optional($teacher->personalInfo)->birthDay) }}" />

                            {{-- Permanent Address (contact_infos table) --}}
                            <x-form-text-input-section
                            size="sm:col-span-2"
                            name="perm_address1"
                            id="perm_address1"
                            label="Permanent Address Line 1"
                            value="{{ old('perm_address1', optional($teacher->contactInfo)->permAddressLine1) }}" />
                            <x-form-text-input-section
                            size="sm:col-span-2"
                            name="perm_address2"
                            id="perm_address2"
                            label="Permanent Address Line 2"
                            value="{{ old('perm_address2', optional($teacher->contactInfo)->permAddressLine2) }}" />
                            <x-form-text-input-section
                            size="sm:col-span-2"
                            name="perm_address3"
                            id="perm_address3"
                            label="Permanent Address Line 3"
                            value="{{ old('perm_address3', optional($teacher->contactInfo)->permAddressLine3) }}" />

                            {{-- Residential Address (contact_infos table) --}}
                            <x-form-text-input-section
                            size="sm:col-span-2"
                            name="res_address1"
                            id="res_address1"
                            label="Residential Address Line 1"
                            value="{{ old('res_address1', optional($teacher->contactInfo)->tempAddressLine1) }}" />
                            <x-form-text-input-section
                            size="sm:col-span-2"
                            name="res_address2"
                            id="res_address2"
                            label="Residential Address Line 2"
                            value="{{ old('res_address2', optional($teacher->contactInfo)->tempAddressLine2) }}" />
                            <x-form-text-input-section
                            size="sm:col-span-2"
                            name="res_address3"
                            id="res_address3"
                            label="Residential Address Line 3"
                            value="{{ old('res_address3', optional($teacher->contactInfo)->tempAddressLine3) }}" />

                            {{-- Mobile Numbers (contact_infos table) --}}
                            <x-form-text-input-section
                            size="sm:col-span-3"
                            name="mobile1"
                            id="mobile1"
                            label="Mobile 1"
                            value="{{ old('mobile1', optional($teacher->contactInfo)->mobile1) }}" />
                            <x-form-text-input-section
                            size="sm:col-span-3"
                            name="mobile2"
                            id="mobile2"
                            label="Mobile 2 / WhatsApp"
                            value="{{ old('mobile2', optional($teacher->contactInfo)->mobile2) }}" />

                        </div>
                        <div class="mt-10">
                            <x-form-button-primary size="" text="Update" modelBinding=""/>
                        </div>
                    </form>
                    @endif

                    @if($section === 'personal-info')
                    <form method="POST" action="{{ route('teacher.profileupdate') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $decryptedId }}">
                        <input type="hidden" name="section" value="personal-info">
                        <div class="grid sm:grid-cols-3 gap-6">

                            <x-form-list-input-section
                                size="sm:col-span-1"
                                name="race"
                                id="race"
                                :options="$races"
                                label="Race"
                                :selected="old('race', optional($teacher->personalInfo)->raceId)" />

                            <x-form-list-input-section
                                size="sm:col-span-1"
                                name="religion"
                                id="religion"
                                :options="$religions"
                                label="Religion"
                                :selected="old('religion', optional($teacher->personalInfo)->religionId)" />

                            <x-form-list-input-section
                                size="sm:col-span-1"
                                name="civilStatus"
                                id="civilStatus"
                                :options="$civilStatuses"
                                label="Civil Status"
                                :selected="old('civilStatus', optional($teacher->personalInfo)->civilStatusId)" />

                            <x-form-list-input-section
                                size="sm:col-span-1"
                                name="genders"
                                id="genders"
                                :options="$genders"
                                label="Gender"
                                :selected="old('gender', optional($teacher->personalInfo)->genderId)" />

                            <x-form-date-input-section
                                size="sm:col-span-1"
                                name="birthDay"
                                id="birthDay"
                                type="date"
                                label="Birth Day"
                                value="{{ old('birthDay', optional($teacher->personalInfo)->birthDay) }}" />

                        </div>
                        <div class="mt-10">
                            <x-form-button-primary size="" text="Update" modelBinding=""/>
                        </div>
                    </form>
                    @endif

                    @if($section === 'location-info')
                    <form action="{{ route('teacher.profileupdate', ['id' => $encryptedId]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $decryptedId }}">
                        <input type="hidden" name="section" value="location-info">
                        <div class="form-group mt-2">
                            <p class="block font-medium text-sm text-gray-700 dark:text-white ">Residential Education Division</p>
                            @livewire('form-location-edu-division-list')

                            <p class="block font-medium text-sm text-gray-700 dark:text-white ">GN Division</p>
                            @livewire('form-location-gn-division-list')
                        </div>

                        <div class="mt-10">
                            <x-form-button-primary size="" text="Update" modelBinding=""/>
                        </div>
                    </form>
                    @endif

                    @if($section === 'rank-info')
                    <form action="{{ route('teacher.profileupdate', ['id' => $encryptedId]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $decryptedId }}">
                        <input type="hidden" name="section" value="rank-info">
                        <div class="grid sm:grid-cols-3 gap-6">
                            <x-form-list-input-section
                                size="sm:col-span-1"
                                name="rankId"
                                id="rankId"
                                :options="$ranks"
                                label="Rank"
                                :selected="old('rankId')" />

                            <x-form-date-input-section
                                size="sm:col-span-1"
                                name="rankedDate"
                                id="rankedDate"
                                type="date"
                                label="Ranked Date"
                                value="{{ old('rankedDate') }}" />
                            <br>
                            <div class="mt-2">
                                <label>
                                    <input type="checkbox" name="deleteRank" />
                                    <span class="block font-medium text-sm text-gray-700 dark:text-white ">Delete Rank</span>
                                </label>
                            </div>
                        </div>
                        <x-form-button-primary size="" text="Save Rank" modelBinding=""/>
                    </form>

                    {{-- Display existing ranks with delete --}}
                    <div class="mt-4 flex justify-center">
                        <table class="w-1/2 border-collapse border border-gray-300">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr class="text-left text-sm font-medium text-gray-700 dark:text-white">
                                    <th class="border px-2 py-1">Rank</th>
                                    <th class="border px-2 py-1">Date</th>
                                    <th class="border px-2 py-1">Current</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($userService->serviceInRanks as $rank)
                                    <tr class="text-sm font-medium text-gray-700 dark:text-white">
                                        <td class="border px-2 py-1">{{ $rank->rank->name }}</td>
                                        <td class="border px-2 py-1">{{ $rank->rankedDate }}</td>
                                        <td class="border px-2 py-1">{{ $rank->current ? 'Yes' : 'No' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @endif

                    @if($section === 'family-info')
                    <form action="{{ route('teacher.profileupdate', ['id' => $encryptedId]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $decryptedId }}">
                        <input type="hidden" name="section" value="family-info">

                        <div class="grid sm:grid-cols-4 gap-4 mt-4">
                            <x-form-list-input-section
                                size="sm:col-span-1"
                                name="family[new][memberType]"
                                id="family_memberType_new"
                                :options="$familyMemberTypes"
                                label="Member Type"
                                :selected="old('family.new.memberType')" />

                            <x-form-text-input-section
                                size="sm:col-span-1"
                                name="family[new][name]"
                                id="family_name_new"
                                label="Name"
                                value="{{ old('family.new.name') }}" />

                            <x-form-text-input-section
                                size="sm:col-span-1"
                                name="family[new][nic]"
                                id="family_nic_new"
                                label="NIC"
                                value="{{ old('family.new.nic') }}" />

                            <x-form-text-input-section
                                size="sm:col-span-1"
                                name="family[new][profession]"
                                id="family_profession_new"
                                label="Profession"
                                value="{{ old('family.new.profession') }}" />
                        </div>
                        <div class="mt-10">
                            <x-form-button-primary size="" text="Add Family Member" modelBinding=""/>
                        </div>
                    </form>
                    @endif

                    @if($section === 'education-info')
                        <form action="{{ route('teacher.profileupdate', ['id' => $encryptedId]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $decryptedId }}">
                            <input type="hidden" name="section" value="education-info">

                            <div class="grid sm:grid-cols-3 gap-4 mt-4">
                                <x-form-list-input-section
                                    size="sm:col-span-1"
                                    name="education[new][educationQualificationId]"
                                    id="education_qualification_new"
                                    :options="$educationQualifications"
                                    label="Qualification"
                                    :selected="old('education.new.educationQualificationId')" />

                                <x-form-date-input-section
                                    size="sm:col-span-1"
                                    name="education[new][effectiveDate]"
                                    id="education_effectiveDate_new"
                                    type="date"
                                    label="Effective Date"
                                    value="{{ old('education.new.effectiveDate') }}" />
                            </div>

                            <x-form-button-primary size="" text="Add Qualification" modelBinding="" />
                        </form>

                        {{-- Display existing qualifications --}}
                        <table class="mt-4 w-1/2 border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-2 py-1">Qualification</th>
                                    <th class="px-2 py-1">Effective Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teacher->educationQualificationInfos->where('active', 1) as $edu)
                                    <tr class="text-sm font-medium text-gray-700 dark:text-white">
                                        <td class="px-2 py-1">{{ optional($edu->educationQualification)->name }}</td>
                                        <td class="px-2 py-1">{{ $edu->effectiveDate }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    @if($section === 'professional-info')
                    <form action="{{ route('teacher.profileupdate', ['id' => $encryptedId]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $decryptedId }}">
                        <input type="hidden" name="section" value="professional-info">

                        {{-- Add new professional qualification --}}
                        <div class="grid sm:grid-cols-3 gap-4 mt-4">
                            <x-form-list-input-section
                                size="sm:col-span-1"
                                name="professional[new][professionalQualificationId]"
                                id="professional_qualification_new"
                                :options="$professionalQualifications"
                                label="Professional Qualification"
                                :selected="old('professional.new.professionalQualificationId')" />

                            <x-form-date-input-section
                                size="sm:col-span-1"
                                name="professional[new][effectiveDate]"
                                id="professional_effectiveDate_new"
                                type="date"
                                label="Effective Date"
                                value="{{ old('professional.new.effectiveDate') }}" />
                        </div>

                        <x-form-button-primary size="" text="Add Qualification" modelBinding="" />
                    </form>



                    <table class="mt-4 w-1/2 border border-gray-300">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-2 py-1">Qualification</th>
                                <th class="px-2 py-1">Effective Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teacher->professionalQualificationInfos->where('active', 1) as $prof)
                                <tr class="text-sm font-medium text-gray-700 dark:text-white">
                                    <td class="px-2 py-1">{{ optional($prof->professionalQualification)->name }}</td>
                                    <td class="px-2 py-1">{{ $prof->effectiveDate }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @endif

                    @if($section === 'service-info')
                    <form action="{{ route('teacher.profileupdate', ['id' => $encryptedId]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $decryptedId }}">
                        <input type="hidden" name="section" value="service-info">

                        <div class="grid sm:grid-cols-4 gap-4 mt-4">
                            {{-- Select Service Type --}}
                            <x-form-list-input-section
                                size="sm:col-span-1"
                                name="service[new][serviceId]"
                                id="service_serviceId_new"
                                :options="$services"  {{-- e.g. Teacher, Principal, Non-Academic --}}
                                label="Service Type"
                                :selected="old('service.new.serviceId')" />

                            {{-- Appointment Date --}}
                            <x-form-date-input-section
                                size="sm:col-span-1"
                                name="service[new][appointedDate]"
                                id="service_appointedDate_new"
                                type="date"
                                label="Appointment Date"
                                value="{{ old('service.new.appointedDate') }}" />

                            {{-- Released Date (Optional) --}}
                            <x-form-date-input-section
                                size="sm:col-span-1"
                                name="service[new][releasedDate]"
                                id="service_releasedDate_new"
                                type="date"
                                label="Released Date"
                                value="{{ old('service.new.releasedDate') }}" />

                        </div>

                        <x-form-button-primary size="" text="Save Service Info" modelBinding="" />
                    </form>
                    @endif

                    @if($section === 'appointment-info')
                    <form action="{{ route('teacher.profileupdate', ['id' => $encryptedId]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $decryptedId }}">
                        <input type="hidden" name="section" value="appointment-info">

                        <div class="grid sm:grid-cols-4 gap-4 mt-4">
                            {{-- Select Service Type --}}
                            <x-form-list-input-section
                                size="sm:col-span-1"
                                name="service[new][userInServiceId]"
                                id="service_userInServiceId_new"
                                :options="$allUserServices"
                                label="Service Type"
                                :selected="old('service.new.userInServiceId')" />

                            {{-- Appointment Type --}}
                            <x-form-list-input-section
                                size="sm:col-span-1"
                                name="service[new][appointmentType]"
                                id="service_appointmentType_new"
                                :options="$appointmentTypes"
                                label="Appointment Type"
                                :selected="old('service.new.appointmentType')" />


                            {{-- Appointment Date --}}
                            <x-form-date-input-section
                                size="sm:col-span-1"
                                name="service[new][appointedDate]"
                                id="service_appointedDate_new"
                                type="date"
                                label="Appointment Date"
                                value="{{ old('service.new.appointedDate') }}" />

                            {{-- Released Date (Optional) --}}
                            <x-form-date-input-section
                                size="sm:col-span-1"
                                name="service[new][releasedDate]"
                                id="service_releasedDate_new"
                                type="date"
                                label="Released Date"
                                value="{{ old('service.new.releasedDate') }}" />


                            <span class="sm:col-span-3"> @livewire('form-user-area-school-list')</span>
                        </div>


                        <x-form-button-primary size="" text="Save Service Info" modelBinding="" />
                    </form>
                    @endif

                </div>
            </main>
        </div>
    </div>
</x-app-layout>