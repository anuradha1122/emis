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
                        'Teacher Registration' => null
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
                    <form method="POST" action="{{ route('teacher.register') }}" class="mx-auto mt-8 max-w-xl sm:mt-8" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-6">
                            <x-form-text-input-section size="sm:col-span-6" name="name" id="name" label="Full Name" value="{{ old('name') }}" />
                            <x-form-text-input-section size="sm:col-span-6" name="addressLine1" id="addressLine1" label="Address Line 1" value="{{ old('addressLine1') }}" />
                            <x-form-text-input-section size="sm:col-span-3" name="addressLine2" id="addressLine2" label="Address Line 2" value="{{ old('addressLine2') }}" />
                            <x-form-text-input-section size="sm:col-span-3" name="addressLine3" id="addressLine3" label="Address Line 3" value="{{ old('addressLine3') }}" />
                            <span class="sm:col-span-3">@livewire('FormUserNic')</span>
                            <x-form-text-input-section size="sm:col-span-3" name="mobile" id="mobile" label="Mobile" value="{{ old('mobile') }}" />

                            <x-form-list-input-section size="sm:col-span-3" name="subject" id="subject" :options="$subjects" label="Appointment Subject"/>
                            <span class="sm:col-span-6 px-1">
                                @livewire('form-user-area-school-list')
                                @error('school') <span  class="text-red-500">{{ $message }}</span> @enderror
                            </span>
                            <x-form-list-input-section size="sm:col-span-3" name="medium" id="medium" :options="$appointedMediums" label="Appointment Medium" />
                            <x-form-list-input-section size="sm:col-span-3" name="category" id="category" :options="$appointmentCategories" label="Appointment category" />
                            <x-form-date-input-section size="sm:col-span-3" name="birthDay" id="birthDay" label="Birth Day" value="{{ old('birthDay') }}" />
                            <x-form-list-input-section size="sm:col-span-3" name="ranks" id="ranks" :options="$ranks" label="Service Appointment Rank" />
                            <x-form-date-input-section size="sm:col-span-3" name="serviceDate" id="serviceDate" label="Service Appointed Date" value="{{ old('serviceDate') }}" />
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