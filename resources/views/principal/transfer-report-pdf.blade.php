<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 dark:text-gray-500 leading-tight">
            {{ __('Principal Transfer Report PDF') }}
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
                        'Principal Dashboard' => route('principal.dashboard'),
                        'Principal Report List' => route('principal.reportlist'),
                        'Transfer Full Report PDF' => null
                    ]" />
                </div>

                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100"></h2>
                    <p class="text-gray-600 dark:text-gray-300">Full Report PDF SLPS(Sri Lanka Principal Service)
                    </p>
                </div>

                <!-- Reports Table -->
                <div class="bg-white dark:bg-gray-700 rounded-lg shadow mb-6">
                    <form action="{{ route('principal.exporttransferreportpdf') }}" method="POST" enctype="multipart/form-data" target="_blank">
                        @csrf
                        <div class="w-full grid grid-cols-1 gap-y-1 sm:grid-cols-4">
                            <div class="sm:col-span-4 px-1">
                            @livewire('report-area-filter')
                            </div>
                            <div class="sm:col-span-1 px-1">
                                <x-form-input-label for="schoolAuthority" value="School Authority" />
                                <x-form-list-input-field name="schoolAuthority" id="schoolAuthority" :options="$schoolAuthorityList" wire:model.live="schoolAuthority"/>
                            </div>
                            <div class="sm:col-span-1 px-1">
                                <x-form-input-label for="schoolEthnicity" value="School Ethnicity" />
                                <x-form-list-input-field name="schoolEthnicity" id="schoolEthnicity" :options="$schoolEthnicityList" wire:model.live="schoolEthnicity"/>
                            </div>
                            <div class="sm:col-span-1 px-1">
                                <x-form-input-label for="schoolClass" value="School Classes" />
                                <x-form-list-input-field name="schoolClass" id="schoolClass" :options="$schoolClassList" wire:model.live="schoolClass"/>
                            </div>
                            <div class="sm:col-span-1 px-1">
                                <x-form-input-label for="schoolDensity" value="School Densities" />
                                <x-form-list-input-field name="schoolDensity" id="schoolDensity" :options="$schoolDensityList" wire:model.live="schoolDensity"/>
                            </div>
                            <div class="sm:col-span-1 px-1">
                                <x-form-input-label for="schoolFacility" value="School Facilities" />
                                <x-form-list-input-field name="schoolFacility" id="schoolFacility" :options="$schoolFacilityList" wire:model.live="schoolFacility"/>
                            </div>
                            <div class="sm:col-span-1 px-1">
                                <x-form-input-label for="schoolGender" value="School Gender" />
                                <x-form-list-input-field name="schoolGender" id="schoolGender" :options="$schoolGenderList" wire:model.live="schoolGender"/>
                            </div>
                            <div class="sm:col-span-1 px-1">
                                <x-form-input-label for="schoolLanguage" value="School Languages" />
                                <x-form-list-input-field name="schoolLanguage" id="schoolLanguage" :options="$schoolLanguageList" wire:model.live="schoolLanguage"/>
                            </div>
                        </div>
                        {{-- Show which button was pressed --}}
                        <div class="flex items-center justify-start gap-2 mx-4">
                            <button type="submit" wire:click="$set('reportAction','web')"
                                class="mt-4 p-2 transition duration-200 bg-red-500 hover:bg-red-600 focus:bg-red-700
                                       focus:shadow-sm focus:ring-4 focus:ring-red-500 focus:ring-opacity-50
                                       text-white rounded-lg text-sm shadow-sm hover:shadow-md font-semibold">
                                Get Web
                            </button>

                            <a href="{{ route('principal.transferreportPDF') }}" class="mt-4 p-2 transition duration-200 bg-white hover:bg-white focus:bg-white
                                focus:shadow-sm focus:ring-4 focus:ring-white focus:ring-opacity-50
                                text-black rounded-lg text-sm shadow-sm hover:shadow-md font-semibold">
                                    Refresh
                            </a>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>