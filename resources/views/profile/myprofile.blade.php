<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 dark:text-gray-200 leading-tight">
            {{ __('user Profile') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="mx-auto sm:px-6 lg:px-8">
            <main class="flex-1 overflow-y-auto">
                <div class="mb-6">
                    <!-- Breadcrumb -->
                    <x-breadcrumb :items="[
                        'Home' => route('dashboard'),
                        'My Profile' => null,
                    ]" />
                </div>

                <div>
                    <div class="mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                        <div class="md:flex">
                            <!-- User Image -->
                            {{-- <div class="md:w-1/4 p-6 flex justify-center">
                                <div class="relative">
                                    <img class="w-48 h-48 rounded-full object-cover border-4 border-indigo-500"
                                        src="https://images.unsplash.com/photo-1577880216142-8549e9488dad?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                                        alt="User profile picture" />
                                </div>
                            </div> --}}

                            <!-- User Info -->
                            <div class="md:w-3/4 p-6">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $user->nameWithInitials.' ['.$user->nic.']' }}
                                        </h1>
                                        @foreach($currentAppointments as $currentAppointment)
                                            <p class="text-indigo-600 dark:text-indigo-400 font-semibold">
                                                Role:
                                                @foreach($currentAppointment['currentPositions'] as $pos)
                                                    <span>{{ $pos['positionName'] }} (from {{ $pos['positionedDate'] }})</span>@if (!$loop->last), @endif
                                                @endforeach
                                            </p>
                                        @endforeach


                                    </div>
                                    <div class="flex space-x-2">
                                        {{-- <a href="{{ route('user.profileedit', [
                                                'id' => $user->cryptedId,
                                                'category' => 'position'
                                            ]) }}"
                                        class="bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 p-2 rounded-full hover:bg-indigo-200 dark:hover:bg-indigo-800 inline-flex items-center justify-center">
                                            <i data-lucide="edit"></i>
                                        </a> --}}

                                        {{-- <button
                                            class="bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 p-2 rounded-full hover:bg-indigo-200 dark:hover:bg-indigo-800">
                                            <i data-lucide="phone-call"></i>
                                        </button> --}}
                                    </div>
                                </div>

                                <div class="mt-4 space-y-3">
                                    @php
                                        $userDetails = [
                                            ['icon' => 'user', 'label' => 'Full Name', 'value' => $user->name],
                                            ['icon' => 'calendar-days', 'label' => 'Date of Birth', 'value' => $user->birthDay ? \Carbon\Carbon::parse($user->personalinfo->birthDay)->format('F j, Y') : 'N/A'],
                                            ['icon' => 'map-pin', 'label' => 'Permanent Address', 'value' => trim("{$user->permAddress}", ', ')],
                                            ['icon' => 'map-pin', 'label' => 'Residential Address', 'value' => trim("{$user->tempAddress}", ', ')],
                                            ['icon' => 'mail', 'label' => 'Email', 'value' => $user->email ?? 'N/A'],
                                            ['icon' => 'phone-call', 'label' => 'Contact', 'value' => trim("{$user->mobile1} / WhatsApp: {$user->mobile2}", ' / ')],
                                        ];
                                    @endphp

                                    @foreach($userDetails as $detail)
                                        <div class="flex items-center text-gray-600 dark:text-gray-300 gap-2">
                                            <i data-lucide="{{ $detail['icon'] }}"></i>
                                            <span>{{ $detail['label'] }}: {{ $detail['value'] }}</span>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-200 dark:border-gray-700"></div>

                        <!-- Profile Details -->
                        <div class="p-6">
                            <div class="grid md:grid-cols-2 gap-6">
                                <!-- Personal Info -->
                                <div>
                                    <h3
                                        class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-3 flex items-center">
                                        <i class="fas fa-graduation-cap text-indigo-600 dark:text-indigo-400 mr-2"></i>
                                        Personal Info
                                    </h3>
                                    <ul class="space-y-3">
                                        <li class="flex items-start">
                                            <div class="bg-indigo-100 dark:bg-indigo-900 p-2 rounded-full mr-3">
                                                <i data-lucide="graduation-cap"
                                                    class="text-indigo-600 dark:text-indigo-300 text-xs"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-800 dark:text-gray-100">Race</h4>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $user->race }}</p>
                                            </div>
                                        </li>
                                        <li class="flex items-start">
                                            <div class="bg-indigo-100 dark:bg-indigo-900 p-2 rounded-full mr-3">
                                                <i data-lucide="graduation-cap"
                                                    class="text-indigo-600 dark:text-indigo-300 text-xs"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-800 dark:text-gray-100">Religion</h4>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $user->religion }}</p>
                                            </div>
                                        </li>
                                        <li class="flex items-start">
                                            <div class="bg-indigo-100 dark:bg-indigo-900 p-2 rounded-full mr-3">
                                                <i data-lucide="graduation-cap"
                                                    class="text-indigo-600 dark:text-indigo-300 text-xs"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-800 dark:text-gray-100">Civil Status</h4>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $user->civilStatus }}</p>
                                            </div>
                                        </li>
                                        <li class="flex items-start">
                                            <div class="bg-indigo-100 dark:bg-indigo-900 p-2 rounded-full mr-3">
                                                <i data-lucide="graduation-cap"
                                                    class="text-indigo-600 dark:text-indigo-300 text-xs"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-800 dark:text-gray-100">Gender</h4>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $user->gender }}</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Location Info -->
                                <div>
                                    <h3
                                        class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-3 flex items-center">
                                        <i class="fas fa-book text-indigo-600 dark:text-indigo-400 mr-2"></i>
                                        Location Info
                                    </h3>
                                    <ul class="space-y-3">
                                        <li class="flex items-start">
                                            <div class="p-2 rounded-full mr-3
                                                {{ $user->province ? 'bg-indigo-100 dark:bg-indigo-900' : 'bg-red-100 dark:bg-red-900' }}">

                                                @if($user->province)
                                                    <i data-lucide="check" class="text-indigo-600 dark:text-indigo-300 text-xs"></i>
                                                @else
                                                    <i data-lucide="x" class="text-red-600 dark:text-red-300 text-xs"></i>
                                                @endif
                                            </div>

                                            <div>
                                                <h4 class="font-medium text-gray-800 dark:text-gray-100">Province</h4>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm">
                                                    {{ $user->province ?? 'Not Available' }}
                                                </p>
                                            </div>
                                        </li>

                                        <li class="flex items-start">
                                            <div class="p-2 rounded-full mr-3
                                                {{ $user->district ? 'bg-indigo-100 dark:bg-indigo-900' : 'bg-red-100 dark:bg-red-900' }}">

                                                @if($user->district)
                                                    <i data-lucide="check" class="text-indigo-600 dark:text-indigo-300 text-xs"></i>
                                                @else
                                                    <i data-lucide="x" class="text-red-600 dark:text-red-300 text-xs"></i>
                                                @endif
                                            </div>

                                            <div>
                                                <h4 class="font-medium text-gray-800 dark:text-gray-100">District</h4>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm">
                                                    {{ $user->district ?? 'Not Available' }}
                                                </p>
                                            </div>
                                        </li>

                                        <li class="flex items-start">
                                            <div class="p-2 rounded-full mr-3
                                                {{ $user->dsDivision ? 'bg-indigo-100 dark:bg-indigo-900' : 'bg-red-100 dark:bg-red-900' }}">

                                                @if($user->dsDivision)
                                                    <i data-lucide="check" class="text-indigo-600 dark:text-indigo-300 text-xs"></i>
                                                @else
                                                    <i data-lucide="x" class="text-red-600 dark:text-red-300 text-xs"></i>
                                                @endif
                                            </div>

                                            <div>
                                                <h4 class="font-medium text-gray-800 dark:text-gray-100">DS Division</h4>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm">
                                                    {{ $user->dsDivision ?? 'Not Available' }}
                                                </p>
                                            </div>
                                        </li>

                                        <li class="flex items-start">
                                            <div class="p-2 rounded-full mr-3
                                                {{ $user->gnDivision ? 'bg-indigo-100 dark:bg-indigo-900' : 'bg-red-100 dark:bg-red-900' }}">

                                                @if($user->gnDivision)
                                                    <i data-lucide="check" class="text-indigo-600 dark:text-indigo-300 text-xs"></i>
                                                @else
                                                    <i data-lucide="x" class="text-red-600 dark:text-red-300 text-xs"></i>
                                                @endif
                                            </div>

                                            <div>
                                                <h4 class="font-medium text-gray-800 dark:text-gray-100">GN Division</h4>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm">
                                                    {{ $user->gnDivision ?? 'Not Available' }}
                                                </p>
                                            </div>
                                        </li>

                                        <li class="flex items-start">
                                            <div class="p-2 rounded-full mr-3
                                                {{ $user->educationDivision ? 'bg-indigo-100 dark:bg-indigo-900' : 'bg-red-100 dark:bg-red-900' }}">

                                                @if($user->educationDivision)
                                                    <i data-lucide="check" class="text-indigo-600 dark:text-indigo-300 text-xs"></i>
                                                @else
                                                    <i data-lucide="x" class="text-red-600 dark:text-red-300 text-xs"></i>
                                                @endif
                                            </div>

                                            <div>
                                                <h4 class="font-medium text-gray-800 dark:text-gray-100">Res. Education  Division</h4>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm">
                                                    {{ $user->educationDivision ?? 'Not Available' }}
                                                </p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-200 dark:border-gray-700"></div>

                        <!-- Profile Details -->
                        <div class="p-6">
                            <div class="grid md:grid-cols-2 gap-6">
                                <!-- Personal Info -->
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-3 flex items-center">
                                        <i class="fas fa-medal text-indigo-600 dark:text-indigo-400 mr-2"></i>
                                        Current Rank(s)
                                    </h3>

                                    <ul class="space-y-3">
                                        @forelse($currentServiceRanksArray ?? [] as $rank)
                                            <li class="flex items-start">
                                                <!-- Left Icon -->
                                                <div class="bg-indigo-100 dark:bg-indigo-900 p-2 rounded-full mr-3">
                                                    <i data-lucide="medal" class="text-indigo-600 dark:text-indigo-300 text-xs"></i>
                                                </div>

                                                <!-- Right Content -->
                                                <div>
                                                    <h4 class="font-medium text-gray-800 dark:text-gray-100">
                                                        {{ $rank['rank'] ?? 'Not Available' }}
                                                    </h4>
                                                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                                                        <strong>Effective Date:</strong> {{ $rank['rankedDate'] ?? 'Not Available' }}
                                                    </p>
                                                </div>
                                            </li>
                                        @empty
                                            <li class="text-gray-500 dark:text-gray-400">No rank information available.</li>
                                        @endforelse
                                    </ul>
                                </div>

                                <!-- Location Info -->
                                <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4 flex items-center">
                                        <i class="fas fa-users text-indigo-600 dark:text-indigo-400 mr-2"></i>
                                        Family Information
                                    </h3>

                                    @forelse($family as $member)
                                        <div class="text-gray-600 dark:text-gray-400 text-sm">
                                            <strong>{{ $member['relation'] }}</strong><br>
                                            Name: {{ $member['name'] ?? 'N/A' }}<br>
                                            NIC: {{ $member['nic'] ?? 'N/A' }}<br>
                                            Profession: {{ $member['profession'] ?? 'N/A' }}
                                        </div>
                                    @empty
                                        <p>No family information available.</p>
                                    @endforelse
                                </div>



                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-200 dark:border-gray-700"></div>

                        <!-- Profile Details -->
                        <div class="p-6">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-3 flex items-center">
                                        <i class="fas fa-graduation-cap text-indigo-600 dark:text-indigo-400 mr-2"></i>
                                        Education Qualifications
                                    </h3>

                                    <p class="text-gray-600 dark:text-gray-400 whitespace-pre-line">
                                        {{ $educationQualifications ?: 'No education qualifications available.' }}
                                    </p>
                                </div>

                                <div>
                                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-3 flex items-center">
                                        <i class="fas fa-briefcase text-indigo-600 dark:text-indigo-400 mr-2"></i>
                                        Professional Qualifications
                                    </h3>

                                    <p class="text-gray-600 dark:text-gray-400 whitespace-pre-line">
                                        {{ $professionalQualifications ?: 'No professional qualifications available.' }}
                                    </p>
                                </div>

                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-200 dark:border-gray-700"></div>

                        <!-- Profile Details -->
                        <div class="p-6">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-3 flex items-center">
                                        <i class="fas fa-medal text-indigo-600 dark:text-indigo-400 mr-2"></i>
                                        Current Rank(s)
                                    </h3>

                                    <ul class="space-y-3">
                                        @forelse($currentServiceRanksArray ?? [] as $rank)
                                            <li class="flex items-start">
                                                <!-- Left Icon -->
                                                <div class="bg-indigo-100 dark:bg-indigo-900 p-2 rounded-full mr-3">
                                                    <i data-lucide="medal" class="text-indigo-600 dark:text-indigo-300 text-xs"></i>
                                                </div>

                                                <!-- Right Content -->
                                                <div>
                                                    <h4 class="font-medium text-gray-800 dark:text-gray-100">
                                                        {{ $rank['rank'] ?? 'Not Available' }}
                                                    </h4>
                                                    <p class="text-gray-600 dark:text-gray-400 text-sm">
                                                        <strong>Effective Date:</strong> {{ $rank['rankedDate'] ?? 'Not Available' }}
                                                    </p>
                                                </div>
                                            </li>
                                        @empty
                                            <li class="text-gray-500 dark:text-gray-400">No rank information available.</li>
                                        @endforelse
                                    </ul>
                                </div>

                                <div>
                                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-3 flex items-center">
                                        <i class="fas fa-briefcase text-indigo-600 dark:text-indigo-400 mr-2"></i>
                                        Service Infos
                                    </h3>

                                    <ul class="space-y-3">
                                        {{-- Current Service --}}
                                        @if($currentService)
                                            <li class="flex items-start">
                                                <div class="bg-green-100 dark:bg-green-900 p-2 rounded-full mr-3">
                                                    <i data-lucide="check" class="text-green-600 dark:text-green-300 text-xs"></i>
                                                </div>
                                                <div>
                                                    <h4 class="font-medium text-gray-800 dark:text-gray-100">
                                                        {{ optional($currentService->service)->name ?? 'Not Available' }}
                                                    </h4>

                                                    {{-- Current Appointments --}}
                                                    @forelse($currentAppointments as $app)
                                                        <p class="text-gray-600 dark:text-gray-400 text-sm ml-4">
                                                            <strong>Current Appointment:</strong>
                                                            {{ $app['workPlace'] ?? 'Not Available' }} (from {{ $app['appointedDate'] ?? 'N/A' }})

                                                            @if(!empty($app['currentPositions']))
                                                                <br>
                                                                <strong>Positions:</strong>
                                                                @foreach($app['currentPositions'] as $pos)
                                                                    {{ $pos['positionName'] ?? 'N/A' }} (from {{ $pos['positionedDate'] ?? 'N/A' }})
                                                                    @if (!$loop->last), @endif
                                                                @endforeach
                                                            @endif
                                                        </p>
                                                    @empty
                                                        <p class="text-gray-500 dark:text-gray-400 ml-4">No current appointments available.</p>
                                                    @endforelse

                                                    {{-- Current Attached Appointments --}}
                                                    @forelse($currentAttachedAppointments as $app)
                                                        <p class="text-gray-600 dark:text-gray-400 text-sm ml-4">
                                                            <strong>Attached Appointment:</strong>
                                                            {{ $app['workPlace'] ?? 'Not Available' }} (from {{ $app['appointedDate'] ?? 'N/A' }})
                                                        </p>
                                                    @empty
                                                        <p class="text-gray-500 dark:text-gray-400 ml-4">No attached appointments available.</p>
                                                    @endforelse
                                                </div>
                                            </li>
                                        @else
                                            <li class="text-gray-500 dark:text-gray-400">No current service available.</li>
                                        @endif

                                        {{-- Previous Appointments (under current service) --}}
                                        @if(!empty($previousAppointments) || !empty($previousAttachedAppointments))
                                            <li class="flex items-start mt-2">
                                                <div class="bg-indigo-100 dark:bg-indigo-900 p-2 rounded-full mr-3">
                                                    <i data-lucide="badge" class="text-indigo-600 dark:text-indigo-300 text-xs"></i>
                                                </div>
                                                <div>
                                                    <h4 class="font-medium text-gray-800 dark:text-gray-100">Previous Appointments</h4>

                                                    {{-- Previous Appointments --}}
                                                    @forelse($previousAppointments as $app)
                                                        <p class="text-gray-600 dark:text-gray-400 text-sm ml-4">
                                                            <strong>Previous Appointment:</strong>
                                                            {{ $app['workPlace'] ?? 'Not Available' }}
                                                            (from {{ $app['appointedDate'] ?? 'N/A' }} to {{ $app['releasedDate'] ?? 'Present' }})
                                                        </p>
                                                    @empty
                                                        <p class="text-gray-500 dark:text-gray-400 ml-4">No previous appointments available.</p>
                                                    @endforelse

                                                    {{-- Previous Attached Appointments --}}
                                                    @forelse($previousAttachedAppointments as $app)
                                                        <p class="text-gray-600 dark:text-gray-400 text-sm ml-4">
                                                            <strong>Previous Attached Appointment:</strong>
                                                            {{ $app['workPlace'] ?? 'Not Available' }}
                                                            (from {{ $app['appointedDate'] ?? 'N/A' }} to {{ $app['releasedDate'] ?? 'Present' }})
                                                        </p>
                                                    @empty
                                                        <p class="text-gray-500 dark:text-gray-400 ml-4">No previous attached appointments available.</p>
                                                    @endforelse
                                                </div>
                                            </li>
                                        @endif
                                    </ul>
                                </div>


                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-200 dark:border-gray-700"></div>

                        <!-- Divider -->
                        <div class="border-t border-gray-200 dark:border-gray-700"></div>

                        <!-- Profile Details -->
                        <div class="p-6">
                            <div class="grid md:grid-cols-2 gap-6">
                                <!-- Personal Info -->
                                <div>
                                    <h3
                                        class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-3 flex items-center">
                                        <i class="fas fa-graduation-cap text-indigo-600 dark:text-indigo-400 mr-2"></i>
                                        Login Info
                                        <div class="flex space-x-2">

                                            <a href="{{ route('profile.myprofileedit', [
                                                    'id' => $user->cryptedId,
                                                    'section' => 'login-info'
                                                ]) }}"
                                            class="bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 p-2 rounded-full hover:bg-indigo-200 dark:hover:bg-indigo-800 inline-flex items-center justify-center">
                                                <i data-lucide="edit"></i>
                                            </a>


                                            {{-- Add other action buttons if needed --}}

                                            {{-- <button
                                                class="bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 p-2 rounded-full hover:bg-indigo-200 dark:hover:bg-indigo-800">
                                                <i data-lucide="phone-call"></i>
                                            </button> --}}
                                        </div>
                                    </h3>
                                    <ul class="space-y-3">
                                        <li class="flex items-start">
                                            <div class="bg-indigo-100 dark:bg-indigo-900 p-2 rounded-full mr-3">
                                                <i data-lucide="graduation-cap"
                                                    class="text-indigo-600 dark:text-indigo-300 text-xs"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-800 dark:text-gray-100">NIC</h4>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $user->nic }}</p>
                                            </div>
                                        </li>
                                    </ul>

                                </div>

                                <!-- Location Info -->
                                <div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
