<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 dark:text-gray-500 leading-tight">
            {{ __('Roles Management') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="mx-auto sm:px-6 lg:px-8">
            <main class="flex-1 overflow-y-auto">
                <div class="mb-6">
                    <x-breadcrumb :items="[
                        'Home' => route('dashboard'),
                        'Settings Dashboard' => route('settings.dashboard'),
                        'Roles' => null
                    ]" />
                </div>

                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">Manage Roles</h2>
                    <p class="text-gray-600 dark:text-gray-300">
                        Add, activate, or deactivate user roles in the system.
                    </p>
                </div>

                {{-- Success message --}}
                @if (session('success'))
                    <div class="mb-4 p-4 text-green-800 bg-green-100 dark:bg-green-700 dark:text-green-100 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Create Role Form --}}
                <div class="mt-8 border-t border-gray-200 dark:border-gray-700 pt-6">
                    <form action="{{ route('settings.roles.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid sm:grid-cols-3 gap-4">
                            <x-form-text-input-section
                                size="sm:col-span-3"
                                name="name"
                                id="role_name"
                                label="Role Name"
                                placeholder="e.g., Provincial Admin"
                                value="{{ old('name') }}"
                            />

                            <div class="flex items-end">
                                <x-form-button-primary size="" text="Add Role" modelBinding="" />
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Roles Table --}}
                <div class="mt-8">
                    <table class="w-full border border-gray-300 dark:border-gray-700 rounded-lg overflow-hidden">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 text-left text-sm uppercase tracking-wider">
                                <th class="px-4 py-2">Role Name</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Active</th>
                                <th class="px-4 py-2 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($roles as $role)
                                <tr class="text-gray-700 dark:text-gray-300 text-sm">
                                    <td class="px-4 py-2">{{ $role->name }}</td>
                                    <td class="px-4 py-2">
                                        @if ($role->active)
                                            <span class="text-green-600 font-semibold">Enabled</span>
                                        @else
                                            <span class="text-red-500">Disabled</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        @if ($role->active)
                                            <span class="text-green-600 font-semibold">Active</span>
                                        @else
                                            <span class="text-red-500">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-right flex justify-end space-x-2">
                                        {{-- Toggle status --}}
                                        <form action="{{ route('settings.roles.toggle', $role->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-blue-600 hover:underline">
                                                {{ $role->active ? 'Disable' : 'Enable' }}
                                            </button>
                                        </form>

                                        {{-- Delete --}}
                                        <form action="{{ route('settings.roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this role?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-gray-500 py-4">No roles found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
