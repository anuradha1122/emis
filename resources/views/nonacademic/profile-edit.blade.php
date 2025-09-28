<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumb :list="$option" />
            <div class="isolate bg-white px-6 py-10 sm:py-10 lg:px-8">
                <x-profile-heading heading="{{ $teacher->nameWithInitials }}" subHeading="{{ $teacher->nic }}" image="{{ $teacher->profilePicture }}" />

                <x-form-success message="{{ session('success') }}" />
                <script src="https://unpkg.com/alpinejs" defer></script>
                <form method="POST" action="{{ route('teacher.profileupdate') }}" class="mx-auto mt-8 max-w-xl sm:mt-8" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-6 gap-x-8 gap-y-6 sm:grid-cols-6">
                        @if ($category == 'userName')
                            <x-form-text-input-section size="sm:col-span-6" name="name" id="name" label="Full Name" value="{{ old('name') }}" />
                        @endif

                        @if ($category == 'userContact')

                            <p class="sm:col-span-6">Permenent Address</p>
                            <hr class="sm:col-span-6">
                            <x-form-text-input-section size="sm:col-span-6" name="permAddressLine1" id="permAddressLine1" label="Permenent Address Line 1" value="{{ old('permAddressLine1') }}" />
                            <x-form-text-input-section size="sm:col-span-3" name="permAddressLine2" id="permAddressLine2" label="Permenent Address Line 2" value="{{ old('permAddressLine2') }}" />
                            <x-form-text-input-section size="sm:col-span-3" name="permAddressLine3" id="permAddressLine3" label="Permenent Address Line 3" value="{{ old('permAddressLine3') }}" />

                            <p class="sm:col-span-6">Residential Address</p>
                            <hr class="sm:col-span-6">
                            <x-form-text-input-section size="sm:col-span-6" name="tempAddressLine1" id="tempAddressLine1" label="Temporary Address Line 1" value="{{ old('tempAddressLine1') }}" />
                            <x-form-text-input-section size="sm:col-span-3" name="tempAddressLine2" id="tempAddressLine2" label="Temporary Address Line 2" value="{{ old('tempAddressLine2') }}" />
                            <x-form-text-input-section size="sm:col-span-3" name="tempAddressLine3" id="tempAddressLine3" label="Temporary Address Line 3" value="{{ old('tempAddressLine3') }}" />

                            <p class="sm:col-span-6">Telephone & E-mail</p>
                            <hr class="sm:col-span-6">

                            <x-form-text-input-section size="sm:col-span-3" name="mobile1" id="mobile1" label="Mobile" value="{{ old('mobile1') }}" />
                            <x-form-text-input-section size="sm:col-span-3" name="mobile2" id="mobile2" label="Whatsapp" value="{{ old('mobile2') }}" />
                            <x-form-text-input-section size="sm:col-span-6" name="email" id="email" label="E-mail" value="{{ old('email') }}" />

                        @endif

                        @if($category == 'userPersonal')
                            <x-form-list-input-section size="sm:col-span-3" name="race" id="race" :options="$races" label="Race" />
                            <x-form-list-input-section size="sm:col-span-3" name="religion" id="religion" :options="$religions" label="Religion" />
                            <x-form-list-input-section size="sm:col-span-3" name="civilStatus" id="civilStatus" :options="$civilStatuses" label="Civil Status" />
                            <x-form-date-input-section size="sm:col-span-3" name="birthDay" id="birthDay" label="Birth Day" value="{{ old('birthDay') }}" />
                        @endif

                        @if($category == 'userLocation')
                            <span class="sm:col-span-6">@livewire('formEducationDivision')</span>
                            <span class="sm:col-span-6">@livewire('formGnDivision')</span>
                        @endif

                        @if($category == 'service')
                            <p class="sm:col-span-6">New Service</p>
                            <hr class="sm:col-span-6">
                            <x-form-list-input-section size="sm:col-span-3" name="new_service" id="new_service" :options="$services" label="New Service" />
                            <x-form-date-input-section size="sm:col-span-3" name="startDay" id="startDay" label="Start Day" value="{{ old('startDay') }}" />
                            <p class="sm:col-span-6">Delete or Update Service</p>
                            <hr class="sm:col-span-6">
                            <x-form-list-input-section size="sm:col-span-3" name="current_service" id="current_service" :options="$current_services" label="Services" />
                            <x-form-date-input-section size="sm:col-span-3" name="startDay" id="startDay" label="Start Day" value="{{ old('startDay') }}" />
                            <label class="sm:col-span-3 flex items-center space-x-2">
                                <input
                                    type="checkbox"
                                    name="service_delete[]"
                                    value="your_value_here"
                                    class="text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                >
                                <span>Delete Service Record</span>
                            </label>

                        @endif

                        @if($category == 'userAppointment')
                            @if (session('positionId') == 6)
                                <div x-data="{ showNewApp: false, showPrevApp: false, showDelApp: false }" class="sm:col-span-6 gap-4">

                                    <!-- Add New Appointment -->
                                    <div class="sm:col-span-6 mt-6">
                                        <div class="flex justify-between items-center">
                                            <p class="font-bold">Add New Appointment</p>
                                            <button type="button" @click="showNewApp = !showNewApp" class="text-blue-600 text-sm hover:underline">
                                                <span x-text="showNewApp ? 'Hide' : 'Show'"></span>
                                            </button>
                                        </div>
                                        <hr class="my-2">
                                        <div x-show="showNewApp" class="grid grid-cols-6 gap-6">
                                            <span class="sm:col-span-3">@livewire('formUserSchool')</span>
                                            <x-form-date-input-section size="sm:col-span-3" name="newAppointmentStartDay" id="newAppointmentStartDay" label="Start Day" value="{{ old('newAppointmentStartDay') }}" />
                                        </div>
                                    </div>

                                    <!-- Add Previous Appointment -->
                                    <div class="sm:col-span-6 mt-6">
                                        <div class="flex justify-between items-center">
                                            <p class="font-bold">Add Previous Appointment</p>
                                            <button type="button" @click="showPrevApp = !showPrevApp" class="text-blue-600 text-sm hover:underline">
                                                <span x-text="showPrevApp ? 'Hide' : 'Show'"></span>
                                            </button>
                                        </div>
                                        <hr class="my-2">
                                        <div x-show="showPrevApp" class="grid grid-cols-6 gap-6">
                                            <span class="sm:col-span-6">@livewire('formProvinceSchool')</span>
                                            <x-form-date-input-section size="sm:col-span-3" name="previousAppointmentStartDay" id="previousAppointmentStartDay" label="Start Day" value="{{ old('previousAppointmentStartDay') }}" />
                                            <x-form-date-input-section size="sm:col-span-3" name="previousAppointmentEndDay" id="previousAppointmentEndDay" label="End Day" value="{{ old('previousAppointmentEndDay') }}" />
                                        </div>
                                    </div>

                                    <!-- Delete Appointment -->
                                    <div class="sm:col-span-6 mt-6">
                                        <div class="flex justify-between items-center">
                                            <p class="font-bold">Delete Appointment</p>
                                            <button type="button" @click="showDelApp = !showDelApp" class="text-blue-600 text-sm hover:underline">
                                                <span x-text="showDelApp ? 'Hide' : 'Show'"></span>
                                            </button>
                                        </div>
                                        <hr class="my-2">
                                        <div x-show="showDelApp" class="grid grid-cols-6 gap-6">
                                            <x-form-list-input-section size="sm:col-span-6" name="appointment_list" id="appointment_list" :options="$appointment_lists" label="Appointments" />
                                        </div>
                                    </div>

                                </div>

                            @endif

                            {{-- <p class="sm:col-span-6">Change Semis Position</p>
                            <hr class="sm:col-span-6">
                            <x-form-list-input-section size="sm:col-span-6" name="position" id="position" :options="$positions" label="Current SEMIS Position" /> --}}
                        @endif

                        @if($category == 'userQualification')
                            <div x-data="{ showEduChange: false }" class="sm:col-span-6">
                                <div class="flex justify-between items-center">
                                    <p class="font-bold">Change Education Qualification Detail</p>
                                    <button type="button" @click="showEduChange = !showEduChange" class="text-blue-600 text-sm hover:underline">
                                        <span x-text="showEduChange ? 'Hide' : 'Show'"></span>
                                    </button>
                                </div>
                                <hr class="my-2">
                                <div x-show="showEduChange" class="grid grid-cols-6 gap-6">
                                    <x-form-list-input-section size="sm:col-span-3" name="educationQualification" id="educationQualification" :options="$educationQualifications" label="Highest Education Qualification" />
                                    <x-form-date-input-section size="sm:col-span-3" name="eduEffectiveDay" id="eduEffectiveDay" label="Effective Day" value="{{ old('eduEffectiveDay') }}" />
                                    <x-form-text-input-section size="sm:col-span-6" name="educationDescription" id="educationDescription" label="Description" value="{{ old('educationDescription') }}" />
                                </div>
                            </div>

                            <div x-data="{ showEduDelete: false }" class="sm:col-span-6 mt-6">
                                <div class="flex justify-between items-center">
                                    <p class="font-bold">Delete Education Qualification Detail</p>
                                    <button type="button" @click="showEduDelete = !showEduDelete" class="text-blue-600 text-sm hover:underline">
                                        <span x-text="showEduDelete ? 'Hide' : 'Show'"></span>
                                    </button>
                                </div>
                                <hr class="my-2">
                                <div x-show="showEduDelete" class="grid grid-cols-6 gap-6">
                                    <x-form-list-input-section size="sm:col-span-6" name="userEduQualification" id="userEduQualification" :options="$userEducationalQualifications" label="Teacher Education Qualifications" />
                                </div>
                            </div>

                            <div x-data="{ showProfChange: false }" class="sm:col-span-6 mt-6">
                                <div class="flex justify-between items-center">
                                    <p class="font-bold">Change Professional Qualification Detail</p>
                                    <button type="button" @click="showProfChange = !showProfChange" class="text-blue-600 text-sm hover:underline">
                                        <span x-text="showProfChange ? 'Hide' : 'Show'"></span>
                                    </button>
                                </div>
                                <hr class="my-2">
                                <div x-show="showProfChange" class="grid grid-cols-6 gap-6">
                                    <x-form-list-input-section size="sm:col-span-3" name="professionalQualification" id="professionalQualification" :options="$professionalQualifications" label="Highest Professional Qualification" />
                                    <x-form-date-input-section size="sm:col-span-3" name="profEffectiveDay" id="profEffectiveDay" label="Effective Day" value="{{ old('profEffectiveDay') }}" />
                                    <x-form-text-input-section size="sm:col-span-6" name="professionalDescription" id="professionalDescription" label="Description" value="{{ old('professionalDescription') }}" />
                                </div>
                            </div>

                            <div x-data="{ showProfDelete: false }" class="sm:col-span-6 mt-6">
                                <div class="flex justify-between items-center">
                                    <p class="font-bold">Delete Professional Qualification Detail</p>
                                    <button type="button" @click="showProfDelete = !showProfDelete" class="text-blue-600 text-sm hover:underline">
                                        <span x-text="showProfDelete ? 'Hide' : 'Show'"></span>
                                    </button>
                                </div>
                                <hr class="my-2">
                                <div x-show="showProfDelete" class="grid grid-cols-6 gap-6">
                                    <x-form-list-input-section size="sm:col-span-6" name="userProfQualification" id="userProfQualification" :options="$userProfessionalQualifications" label="Teacher Professional Qualifications" />
                                </div>
                            </div>
                        @endif

                        @if($category == 'userRank')
                            <div x-data="{ showAddRank: false, showDeleteRank: false }" class="sm:col-span-6">

                                {{-- Add Rank --}}
                                <div class="flex justify-between items-center mt-6">
                                    <p class="font-bold">Add Rank Detail</p>
                                    <button type="button" @click="showAddRank = !showAddRank" class="text-blue-600 text-sm hover:underline">
                                        <span x-text="showAddRank ? 'Hide' : 'Show'"></span>
                                    </button>
                                </div>
                                <div x-show="showAddRank" class="grid grid-cols-6 gap-6 mt-4">
                                    <x-form-list-input-section size="sm:col-span-3" name="rank" id="rank" :options="$ranks" label="Rank List" />
                                    <x-form-date-input-section size="sm:col-span-3" name="rankedDate" id="rankedDate" label="Ranked Date" value="{{ old('rankedDate') }}" />
                                </div>

                                {{-- Delete Rank --}}
                                <div class="flex justify-between items-center mt-8">
                                    <p class="font-bold">Delete Rank Detail</p>
                                    <button type="button" @click="showDeleteRank = !showDeleteRank" class="text-blue-600 text-sm hover:underline">
                                        <span x-text="showDeleteRank ? 'Hide' : 'Show'"></span>
                                    </button>
                                </div>
                                <div x-show="showDeleteRank" class="grid grid-cols-6 gap-6 mt-4">
                                    <x-form-list-input-section size="sm:col-span-6" name="userRank" id="userRank" :options="$userRanks" label="Teacher Rank History" />
                                </div>

                            </div>
                        @endif



                        @if($category == 'userFamily')

                            <div x-data="{ showAddFamily: false, showDeleteFamily: false }" class="sm:col-span-6">

                                <!-- Add Family Member Section -->
                                <div class="flex justify-between items-center mt-6">
                                    <p class="font-bold">Add Family Member Detail</p>
                                    <button type="button" @click="showAddFamily = !showAddFamily" class="text-blue-600 text-sm hover:underline">
                                        <span x-text="showAddFamily ? 'Hide' : 'Show'"></span>
                                    </button>
                                </div>
                                <div x-show="showAddFamily" class="grid grid-cols-6 gap-6 mt-4">
                                    <x-form-list-input-section size="sm:col-span-3" name="familyMemberType" id="familyMemberType" :options="$familyMemberTypes" label="Relationship" />
                                    <x-form-text-input-section size="sm:col-span-3" name="familyMemberNic" id="familyMemberNic" label="NIC" value="{{ old('familyMemberNic') }}" />
                                    <x-form-text-input-section size="sm:col-span-6" name="familyMemberName" id="familyMemberName" label="Name" value="{{ old('familyMemberName') }}" />

                                    <p class="font-bold sm:col-span-6">If child, School</p>
                                    <span class="sm:col-span-6">@livewire('formProvinceSchool')</span>

                                    <x-form-text-input-section size="sm:col-span-3" name="familyMemberProfession" id="familyMemberProfession" label="Profession" value="{{ old('familyMemberProfession') }}" />
                                </div>

                                <!-- Delete Family Member Section -->
                                <div class="flex justify-between items-center mt-8">
                                    <p class="font-bold">Delete Family Member Detail</p>
                                    <button type="button" @click="showDeleteFamily = !showDeleteFamily" class="text-blue-600 text-sm hover:underline">
                                        <span x-text="showDeleteFamily ? 'Hide' : 'Show'"></span>
                                    </button>
                                </div>
                                <div x-show="showDeleteFamily" class="grid grid-cols-6 gap-6 mt-4">
                                    <x-form-list-input-section size="sm:col-span-6" name="familyInfo" id="familyInfo" :options="$familyInfos" label="Teacher Family Information" />
                                </div>

                            </div>

                        @endif

                        @if($category == 'userLogin')
                            <p class="text-red-800 sm:col-span-6">* This will change password to first 6 digits of NIC</p>
                        @endif
                        <input type="hidden" name="category" value="{{ $category }}">
                        <input type="hidden" name="userId" value="{{ $teacher->id }}">
                    </div>
                    <div class="mt-10">
                        <x-form-button-primary size="" text="Submit" modelBinding=""/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
