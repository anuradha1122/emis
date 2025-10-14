<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 dark:text-gray-500 leading-tight">
            {{ __('My Profile Edit') }}
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
                        'My Profile' => route('profile.myprofile'),
                        'Edit' => null
                    ]" />
                </div>

                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100"></h2>
                    <p class="text-gray-600 dark:text-gray-300">Manage View My Profile
                    </p>
                </div>
                @if(session('success'))
                    <div class="text-green-600">{{ session('success') }}</div>
                @endif
                @if(session('info'))
                    <div class="text-blue-600">{{ session('info') }}</div>
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
                        {{-- Add / Update Rank --}}
                        <form action="{{ route('teacher.profileupdate', ['id' => $encryptedId]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $decryptedId }}">
                            <input type="hidden" name="section" value="rank-info">
                            <input type="hidden" name="form_action" value="save">

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
                            </div>

                            <x-form-button-primary size="" text="Save Rank" modelBinding="" />
                        </form>

                        {{-- Display Existing Ranks --}}
                        <div class="mt-6 flex justify-center">
                            <table class="w-1/2 border-collapse border border-gray-300">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr class="text-left text-sm font-medium text-gray-700 dark:text-white">
                                        <th class="border px-2 py-1">Rank</th>
                                        <th class="border px-2 py-1">Ranked Date</th>
                                        <th class="border px-2 py-1 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($userService->serviceInRanks->where('active', 1) as $rank)
                                        <tr class="text-sm font-medium text-gray-700 dark:text-white">
                                            <td class="border px-2 py-1">{{ $rank->rank->name ?? 'Unknown' }}</td>
                                            <td class="border px-2 py-1">{{ $rank->rankedDate ?? 'N/A' }}</td>
                                            <td class="border px-2 py-1 text-center">
                                                <form action="{{ route('teacher.profileupdate', ['id' => $encryptedId]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this rank?');">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $decryptedId }}">
                                                    <input type="hidden" name="section" value="rank-info">
                                                    <input type="hidden" name="form_action" value="delete">
                                                    <input type="hidden" name="rankId" value="{{ $rank->rankId }}">
                                                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if($section === 'family-info')
                        {{-- 🔹 ADD FAMILY MEMBER FORM --}}
                        <form action="{{ route('teacher.profileupdate', ['id' => $encryptedId]) }}" method="POST" class="mb-10">
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

                                <p class="sm:col-span-4 text-gray-700 dark:text-gray-100">
                                    Assign School (If Wife/Husband is a Teacher or Children going to School, Assign School)
                                </p>
                                <span class="sm:col-span-2">@livewire('all-school-list')</span>
                            </div>

                            <div class="mt-10">
                                <x-form-button-primary modelBinding="" size="" text="Add Family Member" />
                            </div>
                        </form>

                        {{-- 🔹 FAMILY MEMBER TABLE WITH DELETE BUTTONS --}}
                        <table class="mt-4 w-1/2 border border-gray-300 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-3 py-2 text-left">Name</th>
                                    {{-- <th class="px-3 py-2 text-left">NIC</th>
                                    <th class="px-3 py-2 text-left">Profession</th> --}}
                                    <th class="px-3 py-2 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($familyInfos as $member)
                                    <tr class="border-t text-gray-700 dark:text-white">
                                        <td class="px-3 py-2">{{ $member->name }}</td>
                                        {{-- <td class="px-3 py-2">{{ $member->nic }}</td>
                                        <td class="px-3 py-2">{{ $member->profession }}</td> --}}
                                        <td class="px-3 py-2 text-center">
                                            <form action="{{ route('teacher.profileupdate', ['id' => $encryptedId]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this family member?');">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $decryptedId }}">
                                                <input type="hidden" name="section" value="family-info">
                                                <input type="hidden" name="form_action" value="delete">
                                                <input type="hidden" name="family_id" value="{{ $member->id }}">
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-3 py-2 text-center text-gray-500">No active family members found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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
                                    <th class="px-2 py-1 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teacher->educationQualificationInfos->where('active', 1) as $edu)
                                    <tr class="text-sm font-medium text-gray-700 dark:text-white">
                                        <td class="px-2 py-1">{{ optional($edu->educationQualification)->name }}</td>
                                        <td class="px-2 py-1">{{ $edu->effectiveDate }}</td>
                                        <td class="px-2 py-1 text-center">
                                            <form action="{{ route('teacher.profileupdate', ['id' => $encryptedId]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this qualification?');">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $decryptedId }}">
                                                <input type="hidden" name="section" value="education-info">
                                                <input type="hidden" name="education[{{ $edu->id }}][id]" value="{{ $edu->id }}">
                                                <input type="hidden" name="education[{{ $edu->id }}][delete]" value="1">
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    @if($section === 'professional-info')
                        {{-- Add new professional qualification --}}
                        <form action="{{ route('teacher.profileupdate', ['id' => $encryptedId]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $decryptedId }}">
                            <input type="hidden" name="section" value="professional-info">

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

                        {{-- Display existing qualifications --}}
                        <table class="mt-4 w-1/2 border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-2 py-1">Qualification</th>
                                    <th class="px-2 py-1">Effective Date</th>
                                    <th class="px-2 py-1 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($teacher->professionalQualificationInfos->where('active', 1) as $prof)
                                    <tr class="text-sm font-medium text-gray-700 dark:text-white">
                                        <td class="px-2 py-1">{{ optional($prof->professionalQualification)->name }}</td>
                                        <td class="px-2 py-1">{{ $prof->effectiveDate }}</td>
                                        <td class="px-2 py-1 text-center">
                                            <form action="{{ route('teacher.profileupdate', ['id' => $encryptedId]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this qualification?');">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $decryptedId }}">
                                                <input type="hidden" name="section" value="professional-info">
                                                <input type="hidden" name="professional[{{ $prof->id }}][id]" value="{{ $prof->id }}">
                                                <input type="hidden" name="professional[{{ $prof->id }}][delete]" value="1">
                                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    @if($section === 'teacher-info')
                        <form method="POST" action="{{ route('teacher.profileupdate') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $decryptedId }}">
                            <input type="hidden" name="section" value="teacher-info">
                            <div class="grid sm:grid-cols-3 gap-6">

                                <x-form-list-input-section
                                    size="sm:col-span-1"
                                    name="appointment_subject"
                                    id="appointment_subject"
                                    :options="$subjectLists"
                                    label="Appointment Subject"
                                    :selected="old('appointment_subject', optional($teacher->currentTeacherService->teacherService)->appointmentSubjectId)" />

                                <x-form-list-input-section
                                    size="sm:col-span-1"
                                    name="main_subject"
                                    id="main_subject"
                                    :options="$subjectLists"
                                    label="Main Subject"
                                    :selected="old('main_subject', optional($teacher->currentTeacherService->teacherService)->mainSubjectId)" />

                                <x-form-list-input-section
                                    size="sm:col-span-1"
                                    name="medium"
                                    id="medium"
                                    :options="$appointmentMediums"
                                    label="Appointment Medium"
                                    :selected="old('medium', optional($teacher->currentTeacherService->teacherService)->appointmentMediumId)" />

                                <x-form-list-input-section
                                    size="sm:col-span-1"
                                    name="category"
                                    id="category"
                                    :options="$appointmentCategories"
                                    label="Appointment Category"
                                    :selected="old('category', optional($teacher->currentTeacherService->teacherService)->appointmentCategoryId)" />

                            </div>
                            <div class="mt-10">
                                <x-form-button-primary size="" text="Update" modelBinding=""/>
                            </div>
                        </form>
                    @endif

                    @if($section === 'service-info')
                        <form action="{{ route('teacher.profileupdate', ['id' => $encryptedId]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $decryptedId }}">
                            <input type="hidden" name="section" value="service-info">

                            <div class="grid sm:grid-cols-4 gap-4 mt-4">
                                <x-form-list-input-section
                                    size="sm:col-span-1"
                                    name="service[new][serviceId]"
                                    id="service_serviceId_new"
                                    :options="$services"
                                    label="Service Type"
                                    :selected="old('service.new.serviceId')" />

                                <x-form-date-input-section
                                    size="sm:col-span-1"
                                    name="service[new][appointedDate]"
                                    id="service_appointedDate_new"
                                    type="date"
                                    label="Appointment Date"
                                    value="{{ old('service.new.appointedDate') }}" />

                                <x-form-date-input-section
                                    size="sm:col-span-1"
                                    name="service[new][releasedDate]"
                                    id="service_releasedDate_new"
                                    type="date"
                                    label="Released Date"
                                    value="{{ old('service.new.releasedDate') }}" />
                            </div>

                            <div class="mt-6">
                                <x-form-button-primary size="" modelBinding="" text="Save Service Info" />
                            </div>
                        </form>

                        {{-- Service History Table --}}
                        @if(isset($teacher->services) && $teacher->services->count() > 0)
                            <div class="mt-10">
                                <h3 class="text-lg font-semibold mb-3">Service History</h3>
                                <table class="min-w-full border border-gray-300 text-sm">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="border px-3 py-2 text-left">#</th>
                                            <th class="border px-3 py-2 text-left">Service Type</th>
                                            <th class="border px-3 py-2 text-left">Appointed Date</th>
                                            <th class="border px-3 py-2 text-left">Released Date</th>
                                            <th class="border px-3 py-2 text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($teacher->services as $index => $service)
                                            <tr class="text-sm font-medium text-gray-700 dark:text-white">
                                                <td class="border px-3 py-2">{{ $index + 1 }}</td>
                                                <td class="border px-3 py-2">{{ optional($service->service)->name }}</td>
                                                <td class="border px-3 py-2">{{ $service->appointedDate }}</td>
                                                <td class="border px-3 py-2">{{ $service->releasedDate ?? '-' }}</td>
                                                <td class="border px-3 py-2 text-center">
                                                    <form action="{{ route('teacher.profileupdate', ['id' => $encryptedId]) }}" method="POST" onsubmit="return confirm('Delete this service record?');">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $decryptedId }}">
                                                        <input type="hidden" name="section" value="service-info">
                                                        <input type="hidden" name="delete_service_id" value="{{ $service->id }}">
                                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
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

                        @if(isset($appointments) && $appointments->count())
                            <div class="mt-8">
                                <h3 class="text-lg font-semibold mb-3">Appointment Records</h3>

                                <table class="min-w-full border border-gray-300 rounded-lg">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="p-2 border">#</th>
                                            <th class="p-2 border">Work Place</th>
                                            <th class="p-2 border">Appointed Date</th>
                                            <th class="p-2 border">Released Date</th>
                                            <th class="p-2 border">Appointment Type</th>
                                            <th class="p-2 border">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($appointments as $index => $app)
                                            <tr class="text-sm font-medium text-gray-700 dark:text-white">
                                                <td class="p-2 border text-center">{{ $index + 1 }}</td>
                                                <td class="p-2 border">{{ optional($app->workPlace)->name ?? '-' }}</td>
                                                <td class="p-2 border text-center">{{ $app->appointedDate ?? '-' }}</td>
                                                <td class="p-2 border text-center">{{ $app->releasedDate ?? '-' }}</td>
                                                <td class="p-2 border text-center">
                                                    {{ $app->appointmentType == 1 ? 'Permanent' : 'Attachment' }}
                                                </td>
                                                <td class="p-2 border text-center">
                                                    <form action="{{ route('teacher.profileupdate', ['id' => $encryptedId]) }}" method="POST" onsubmit="return confirm('Delete this record?');">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $decryptedId }}">
                                                        <input type="hidden" name="section" value="appointment-info">
                                                        <input type="hidden" name="delete_appointment_id" value="{{ $app->id }}">
                                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif


                    @endif

                    @if($section === 'position-info')
                        {{-- Add / Save New Position --}}
                        <form action="{{ route('teacher.profileupdate', ['id' => $encryptedId]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $decryptedId }}">
                            <input type="hidden" name="section" value="position-info">
                            <input type="hidden" name="form_action" value="save">

                            <div class="grid sm:grid-cols-4 gap-4 mt-4">
                                {{-- Appointment Selection --}}
                                <x-form-list-input-section
                                    size="sm:col-span-1"
                                    name="position[new][userServiceAppId]"
                                    id="position_userServiceAppId_new"
                                    :options="$appointments->map(function($app) {
                                        $label = ($app->workPlace->name ?? 'Unknown Workplace')
                                            . ' (' . ($app->appointedDate ?? 'N/A')
                                            . ' - ' . ($app->releasedDate ?? 'Present') . ')';
                                        return (object)[
                                            'id' => $app->id,
                                            'name' => $label,
                                        ];
                                    })->values()"
                                    label="Select Appointment"
                                    :selected="old('position.new.userServiceAppId')" />

                                {{-- Position Selection --}}
                                <x-form-list-input-section
                                    size="sm:col-span-1"
                                    name="position[new][positionId]"
                                    id="position_positionId_new"
                                    :options="$positions"
                                    label="Position"
                                    :selected="old('position.new.positionId')" />

                                {{-- Positioned Date --}}
                                <x-form-date-input-section
                                    size="sm:col-span-1"
                                    name="position[new][positionedDate]"
                                    id="position_positionedDate_new"
                                    type="date"
                                    label="Positioned Date"
                                    value="{{ old('position.new.positionedDate') }}" />
                            </div>

                            <div class="mt-4">
                                <x-form-button-primary size="" modelBinding="" text="Save Position Info" />
                            </div>
                        </form>

                        {{-- Existing Positions Table --}}
                        @if(isset($existingPositions) && $existingPositions->count())
                            <div class="mt-10">
                                <h3 class="text-lg font-semibold mb-3">Existing Positions</h3>
                                <table class="min-w-full border border-gray-300 rounded-lg text-sm">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="p-2 border">#</th>
                                            <th class="p-2 border">Appointment</th>
                                            <th class="p-2 border">Position</th>
                                            <th class="p-2 border">Positioned Date</th>
                                            {{-- <th class="p-2 border">Status</th> --}}
                                            <th class="p-2 border">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($existingPositions as $index => $pos)
                                            <tr class="text-sm font-medium text-gray-700 dark:text-white">
                                                <td class="p-2 border text-center">{{ $index + 1 }}</td>
                                                <td class="p-2 border">
                                                    {{ optional($pos->appointment->workPlace)->name ?? 'N/A' }}
                                                </td>
                                                <td class="p-2 border">{{ $pos->position->name ?? 'Unknown' }}</td>
                                                <td class="p-2 border text-center">{{ $pos->positionedDate ?? '-' }}</td>
                                                {{-- <td class="p-2 border text-center">
                                                    @if(isset($pos->active) && $pos->active == 1)
                                                        <span class="text-green-600 font-semibold">Active</span>
                                                    @else
                                                        <span class="text-gray-500">Inactive</span>
                                                    @endif
                                                </td> --}}
                                                <td class="p-2 border text-center">
                                                    <form action="{{ route('teacher.profileupdate', ['id' => $encryptedId]) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this position?');">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $decryptedId }}">
                                                        <input type="hidden" name="section" value="position-info">
                                                        <input type="hidden" name="form_action" value="delete">
                                                        <input type="hidden" name="position[delete][id]" value="{{ $pos->id }}">
                                                        <button type="submit"
                                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    @endif

                    @if($section === 'login-info')
                        <form action="{{ route('profile.myprofilestore') }}" method="POST">
                            @csrf
                            <input type="hidden" name="section" value="login-info">

                            <div class="grid sm:grid-cols-3 gap-4 my-4 pb-5">
                                <x-form-text-input-section
                                    size="sm:col-span-2"
                                    name="password"
                                    id="password"
                                    label="New Password"
                                    value=""
                                    type="password"
                                />

                                <x-form-text-input-section
                                    size="sm:col-span-2"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    label="Confirm Password"
                                    value=""
                                    type="password"
                                />

                            </div>

                            <div class="flex items-center justify-start gap-2 mx-4">
                                <button type="submit"
                                    class="mt-4 p-2 transition duration-200 bg-blue-500 hover:bg-blue-600 focus:bg-blue-700
                                           focus:shadow-sm focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50
                                           text-white rounded-lg text-sm shadow-sm hover:shadow-md font-semibold">
                                    Submit
                                </button>

                                <a href="{{ route('profile.myprofile') }}" class="mt-4 p-2 transition duration-200 bg-white hover:bg-white focus:bg-white
                                    focus:shadow-sm focus:ring-4 focus:ring-white focus:ring-opacity-50
                                    text-black rounded-lg text-sm shadow-sm hover:shadow-md font-semibold">
                                        Back
                                </a>
                            </div>
                        </form>
                    @endif

                </div>
            </main>
        </div>
    </div>
</x-app-layout>