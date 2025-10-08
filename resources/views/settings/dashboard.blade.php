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
                        title="Roles"
                        icon="school"
                        value="{{ $settingsCount['role_count'] }}"
                        trend="Change"
                        trendText="View Details"
                        trendColor="green"
                        :trendLink="route('settings.roles.list')"
                    />


                    <x-dashboard-card
                        title="Permissions"
                        icon="lock"
                        value="{{ $settingsCount['permission_count'] }}"
                        trend="change"
                        trendText="Permissions"
                        trendColor="blue"
                        :trendLink="route('settings.permissionlist')"
                    />

                    <x-dashboard-card
                        title="User Roles"
                        icon="lock"
                        value="{{ $settingsCount['role_user_count'] }}"
                        trend="change"
                        trendText="User Roles"
                        trendColor="red"
                        :trendLink="route('settings.rolepermission')"
                    />

                </div>
            </main>
        </div>
    </div>
</x-app-layout>
