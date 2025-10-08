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
                    @if (session('success'))
                        <div class="mb-4 p-4 text-green-800 bg-green-100 dark:bg-green-700 dark:text-green-100 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>

                <!-- Recent Orders Table -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
                        <h3 class="font-semibold text-lg text-gray-900 dark:text-gray-100"> Allocate Permissions</h3>
                        <button
                            class="px-4 py-2 bg-primary-500 dark:bg-primary-600 text-white rounded-lg hover:bg-primary-600 dark:hover:bg-primary-700 text-sm"></button>
                    </div>
                    <div class="overflow-x-auto p-4">
                        <form action="{{ route('settings.storepermission') }}" method="POST">
                            @csrf

                            <!-- 1. Select dropdown -->
                            <div class="mb-4">
                                <label for="role" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                                    Select Role
                                </label>
                                <select name="role_id" id="role" class="w-full border-gray-300 dark:border-gray-600 rounded-lg p-2 dark:bg-gray-700 dark:text-white">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- 2. Checkboxes in 3 columns -->
                            <div class="mb-4">
                                <span class="block text-gray-700 dark:text-gray-300 font-medium mb-2">Select Permissions</span>
                                <div class="grid grid-cols-3 gap-4">
                                    @foreach ($permissions as $permission)
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="form-checkbox text-primary-500 dark:text-primary-400">
                                            <span class="ml-2 text-gray-700 dark:text-gray-300">{{ $permission->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>


                            <!-- 3. Submit button -->
                            <x-form-button-primary size="" text="Assign Permission" modelBinding=""/>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

</x-app-layout>
