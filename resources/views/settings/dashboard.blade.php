<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 dark:text-gray-700 leading-tight">
            {{ __('Dashboard Overview') }}
        </h2>

        <x-breadcrumb :items="[
            'Home' => route('dashboard'),
            'Settings Dashboard' => null,
        ]" />
    </x-slot>



    <div class="py-6 bg-gray-100 dark:bg-gray-900 min-h-screen">

        <div class="mx-auto sm:px-6 lg:px-8">
            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto">
                <div class="mb-6">
                    <p class="text-gray-600 dark:text-gray-300">Welcome back, Madusanka! Here's what's happening today.
                    </p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

                    <x-dashboard-card
                        title="Races"
                        icon="school"
                        value="4"
                        trend="change"
                        trendText="Races"
                        trendColor="green"
                    />

                    <x-dashboard-card
                        title="Religions"
                        icon="users"
                        value="5"
                        trend="change"
                        trendText="Religions"
                        trendColor="blue"
                    />

                    <x-dashboard-card
                        title="Civil Status"
                        icon="user-check"
                        value="5"
                        trend="change"
                        trendText="Civil Status"
                        trendColor="yellow"
                    />

                    <x-dashboard-card
                        title="Mediums"
                        icon="globe"
                        value="3"
                        trend="change"
                        trendText="Mediums"
                        trendColor="purple"
                    />

                </div>

                <!-- Recent Orders Table -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100">Permission List</h3>
                        <a href="{{ route('settings.permissionlist') }}" class="px-4 py-2 bg-primary-500 dark:bg-primary-600 text-white rounded-lg hover:bg-primary-600 dark:hover:bg-primary-700 text-sm">
                            View All
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-700">
                                    <th
                                        class="py-3 px-4 text-left text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        ID</th>
                                    <th
                                        class="py-3 px-4 text-left text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Permission</th>
                                    <th
                                        class="py-3 px-4 text-left text-sm font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <td class="py-3 px-4 text-gray-700 dark:text-gray-300">{{ $permission->id }}</td>
                                        <td class="py-3 px-4 text-gray-700 dark:text-gray-300">{{ $permission->name }}</td>
                                        <td class="py-3 px-4 text-gray-700 dark:text-gray-300">{{ $permission->description }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
