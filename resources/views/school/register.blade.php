<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 dark:text-gray-500 leading-tight">
            {{ __('School Registration') }}
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
                        'School Dashboard' => route('school.dashboard'),
                        'School Registration' => null
                    ]" />
                </div>

                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100"></h2>
                    <p class="text-gray-600 dark:text-gray-300">School Registration Form
                    </p>
                </div>
                @if (session('success'))
                    <div class="mb-4 p-4 text-green-800 bg-green-100 dark:bg-green-700 dark:text-green-100 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="mt-8 border-t border-gray-200 dark:border-gray-700">
                    <form method="POST" action="{{ route('school.register') }}" class="mx-auto mt-8 max-w-xl sm:mt-8" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-6">
                            <x-form-text-input-section size="sm:col-span-6" name="name" id="name" label="Full Name" value="{{ old('name') }}" />
                            <x-form-text-input-section size="sm:col-span-6" name="addressLine1" id="addressLine1" label="Address Line 1" value="{{ old('addressLine1') }}" />
                            <x-form-text-input-section size="sm:col-span-3" name="addressLine2" id="addressLine2" label="Address Line 2" value="{{ old('addressLine2') }}" />
                            <x-form-text-input-section size="sm:col-span-3" name="addressLine3" id="addressLine3" label="Address Line 3" value="{{ old('addressLine3') }}" />
                            <x-form-text-input-section size="sm:col-span-3" name="mobile" id="mobile" label="Telephone" value="{{ old('mobile') }}" />
                            <x-form-text-input-section size="sm:col-span-3" name="census" id="census" label="Census No" value="{{ old('census') }}" />

                            <span class="sm:col-span-6 px-1">
                                @livewire('form-user-area-division-list')
                                @error('division') <span  class="text-red-500">{{ $message }}</span> @enderror
                            </span>

                            <x-form-list-input-section
                                size="sm:col-span-3"
                                name="authorities"
                                id="authorities"
                                :options="$schoolAuthorityList"
                                selected=""
                                label="School Authority" />

                            <x-form-list-input-section
                                size="sm:col-span-3"
                                name="ethnicity"
                                id="ethnicity"
                                :options="$schoolEthnicityList"
                                selected=""
                                label="School Ethnicity" />

                            <x-form-list-input-section
                                size="sm:col-span-3"
                                name="class"
                                id="class"
                                :options="$schoolClassList"
                                selected=""
                                label="School Class" />

                            <x-form-list-input-section
                                size="sm:col-span-3"
                                name="density"
                                id="density"
                                :options="$schoolDensityList"
                                selected=""
                                label="School Density" />

                            <x-form-list-input-section
                                size="sm:col-span-3"
                                name="facility"
                                id="facility"
                                :options="$schoolFacilityList"
                                selected=""
                                label="School Facility" />

                            <x-form-list-input-section
                                size="sm:col-span-3"
                                name="gender"
                                id="gender"
                                :options="$schoolGenderList"
                                selected=""
                                label="School Gender" />

                            <x-form-list-input-section
                                size="sm:col-span-3"
                                name="language"
                                id="language"
                                :options="$schoolLanguageList"
                                selected=""
                                label="School Language" />

                            <x-form-list-input-section
                                size="sm:col-span-3"
                                name="religion"
                                id="religion"
                                :options="$schoolMainReligionList"
                                selected=""
                                label="Main Religion" />

                            {{-- <span class="sm:col-span-4">@livewire('formUserProfilePicture')</span> --}}
                        </div>
                        <div class="mt-10">
                            <x-form-button-primary size="" text="Register" modelBinding=""/>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>