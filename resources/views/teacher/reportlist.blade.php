<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 dark:text-gray-500 leading-tight">
            {{ __('Teacher Report List') }}
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
                        'Teacher Report List' => null
                    ]" />
                </div>

                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100"></h2>
                    <p class="text-gray-600 dark:text-gray-300">Select Reports SLTS(Sri Lanka Teacher Service)
                    </p>
                </div>

                <!-- Reports Table -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100">Reports List</h3>
                        <button
                            class="px-4 py-2 bg-primary-500 dark:bg-primary-600 text-white rounded-lg hover:bg-primary-600 dark:hover:bg-primary-700 text-sm"></button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-700">
                                    <th
                                        class="py-3 px-4 text-left text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Report ID</th>
                                    <th
                                        class="py-3 px-4 text-left text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Report</th>
                                    <th
                                        class="py-3 px-4 text-left text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="py-3 px-4 text-left text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (Auth::user()->hasPermission('slts_full_report'))
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">#1001</td>
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">Teacher Full Report</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 text-xs text-white bg-blue-500 rounded">Web</span>
                                        <span class="px-2 py-1 text-xs text-white bg-green-500 rounded">Excel</span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <a href="{{ route('teacher.fullreport') }}" class="text-blue-500 dark:text-blue-400 hover:underline">View</a>
                                    </td>
                                </tr>
                                @endif
                                @if (Auth::user()->hasPermission('slts_full_report_pdf'))
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">#1002</td>
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">Teacher Full Report PDF</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 text-xs text-white bg-red-500 rounded">PDF</span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <a href="{{ route('teacher.fullreportPDF') }}" class="text-blue-500 dark:text-blue-400 hover:underline">View</a>
                                    </td>
                                </tr>
                                @endif

                                {{-- <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">#1003</td>
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">Teacher Transfer Report</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 text-xs text-white bg-blue-500 rounded">Web</span>
                                        <span class="px-2 py-1 text-xs text-white bg-green-500 rounded">Excel</span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <a href="{{ route('teacher.transferreport') }}" class="text-blue-500 dark:text-blue-400 hover:underline">View</a>
                                    </td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>