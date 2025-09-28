<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 dark:text-gray-700 leading-tight">
            {{ __('Dashboard Overview') }}
        </h2>
        <x-breadcrumb :items="[
            'Home' => route('dashboard'),
            'Settings Dashboard' => route('settings.dashboard'),
            'Permissions List' => null,
        ]" />
    </x-slot>

    <div class="py-6 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="mx-auto sm:px-6 lg:px-8">
            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto">
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100"></h2>
                    <p class="text-gray-600 dark:text-gray-300">You can adjust the permissions for different roles
                        here.
                    </p>
                </div>

                <!-- Recent Orders Table -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100">Permissions</h3>
                        <a href="{{ route('settings.updatepermission') }}" class="px-4 py-2 bg-primary-500 dark:bg-primary-600 text-white rounded-lg hover:bg-primary-600 dark:hover:bg-primary-700 text-sm">
                            Update Permissions
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
                        <!-- Render pagination links -->
                        {{ $permissions->links() }}
                    </div>
                </div>
            </main>
        </div>
    </div>

</x-app-layout>
