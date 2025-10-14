<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 dark:text-gray-500 leading-tight">
            {{ __('School Dashboard') }}
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
                        'School Dashboard' => null,
                    ]" />
                </div>

                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100"></h2>
                    <p class="text-gray-600 dark:text-gray-300">Manage View School Profiles
                    </p>
                </div>

                <div class="mt-8 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex justify-end items-center p-6 gap-2">

                        <a href="{{ route('school.register') }}"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white dark:text-gray-100 font-bold py-3 px-8 rounded-full transition duration-300">
                            Register
                        </a>


                        <button x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'school-search')"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white dark:text-gray-100 font-bold py-3 px-8 rounded-full transition duration-300">
                            Search
                        </button>
                        <x-modal name="school-search" :show="$errors->userDeletion->isNotEmpty()" focusable>
                            <livewire:school-search />
                        </x-modal>



                        <a href="{{ route('school.reportlist') }}"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white dark:text-gray-100 font-bold py-3 px-8 rounded-full transition duration-300">
                            Reports
                        </a>

                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

                    {{-- Appointment ≥ 10 years --}}
                    <x-dashboard-card
                    title="{{ $schoolCounts->card_1_name }}"
                    icon="calendar-check"  {{-- indicates current appointment --}}
                    value="{{ $schoolCounts->card_1 }}"
                    trend="See"
                    trendText="List"
                    trendColor="purple"
                    />

                    {{-- Service ≥ 30 years --}}
                    <x-dashboard-card
                    title="{{ $schoolCounts->card_2_name }}"
                    icon="award"  {{-- indicates long service / achievement --}}
                    value="{{$schoolCounts->card_2 }}"
                    trend="See"
                    trendText="List"
                    trendColor="red"
                    />



                    <x-dashboard-card
                        title="{{ $schoolCounts->card_3_name }}"
                        icon="mars"
                        value="{{ $schoolCounts->card_3 }}"
                        trend="See"
                        trendText="List"
                        trendColor="blue"
                    />


                    <x-dashboard-card
                        title="{{ $schoolCounts->card_4_name }}"
                        icon="venus"
                        value="{{ $schoolCounts->card_4 }}"
                        trend="See"
                        trendText="List"
                        trendColor="pink"
                    />
                </div>

                <!-- Charts Section -->
                {{-- <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <x-chart-card
                        id="ageChart"
                        :labels="array_keys($schoolCounts['ageGroups'])"
                        :data="array_values($schoolCounts['ageGroups'])"
                        title="Teacher Appointment Periods"
                        type="bar"
                        dataset-label="Teachers"
                    />

                    <x-chart-card
                        id="provinceChart"
                        :labels="array_keys($schoolCounts['appointmentPeriods'])"
                        :data="array_values($schoolCounts['appointmentPeriods'])"
                        title="Teacher Age Groups"
                        type="pie"
                    />
                </div> --}}

                @stack('scripts') {{-- This renders all the chart scripts --}}
            </main>
        </div>
    </div>
</x-app-layout>