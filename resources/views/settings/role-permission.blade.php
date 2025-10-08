<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 dark:text-gray-700 leading-tight">
            {{ __('Dashboard Overview') }}
        </h2>
        <x-breadcrumb :items="[
            'Home' => route('dashboard'),
            'Settings Dashboard' => route('settings.dashboard'),
            'Role Permissions' => null,
        ]" />
    </x-slot>

    <div class="py-6 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="mx-auto sm:px-6 lg:px-8">
            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto">
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100"></h2>
                    <p class="text-gray-600 dark:text-gray-300">You can adjust the permissions for users
                        here.
                    </p>
                    @if (session('success'))
                        <div class="mb-4 p-4 text-green-800 bg-green-100 dark:bg-green-700 dark:text-green-100 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>

                <!-- Recent Orders Table -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100"> Allocate Permissions to User</h3>
                        <button
                            class="px-4 py-2 bg-primary-500 dark:bg-primary-600 text-white rounded-lg hover:bg-primary-600 dark:hover:bg-primary-700 text-sm"></button>
                    </div>
                    <div class="overflow-x-auto p-4">
                        <form action="{{ route('settings.storerolepermission') }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-6 mb-6">
                                <span class="sm:col-span-2">@livewire('RoleNic')</span>

                                <x-form-list-input-section
                                    size="sm:col-span-2"
                                    name="role"
                                    id="role"
                                    :options="$roles"
                                    selected=""
                                    label="Roles" />
                            </div>

                            <x-form-button-primary size="" text="Assign Permission" modelBinding="" />
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

</x-app-layout>
