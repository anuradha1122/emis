<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 dark:text-gray-500 leading-tight">
            {{ __('Teacher Full Report') }}
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
                        'Teacher Report List' => route('teacher.reportlist'),
                        'Teacher Transfer Report' => null
                    ]" />
                </div>

                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100"></h2>
                    <p class="text-gray-600 dark:text-gray-300">Transfer Report SLTS(Sri Lanka Teacher Service)
                    </p>
                </div>

                <!-- Reports Table -->
                <div class="bg-white dark:bg-gray-700 rounded-lg shadow mb-6">
                    @livewire('teacherTransferReport')
                </div>
            </main>
        </div>
    </div>
</x-app-layout>