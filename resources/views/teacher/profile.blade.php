<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 dark:text-gray-200 leading-tight">
            {{ __('Teacher Profile') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <div class="mx-auto sm:px-6 lg:px-8">
            <main class="flex-1 overflow-y-auto">
                <div class="mb-6">
                    <!-- Breadcrumb -->
                    <x-breadcrumb :items="[
                        'Home' => route('dashboard'),
                        'Teacher Dashboard' => route('teacher.dashboard'),
                        'Profile' => null,
                    ]" />
                </div>

                <div>
                    <div class="mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
                        <div class="md:flex">
                            <!-- Teacher Image -->
                            {{-- <div class="md:w-1/4 p-6 flex justify-center">
                                <div class="relative">
                                    <img class="w-48 h-48 rounded-full object-cover border-4 border-indigo-500"
                                        src="https://images.unsplash.com/photo-1577880216142-8549e9488dad?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                                        alt="Teacher profile picture" />
                                </div>
                            </div> --}}

                            <!-- Teacher Info -->
                            <div class="md:w-3/4 p-6">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">{{ $teacher->nameWithInitials.' ['.$teacher->nic.']' }}
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
                                        @if (Auth::user()->hasPermission('slts_personal_edit'))
                                        <a href="{{ route('teacher.profileedit', [
                                                'id' => $teacher->cryptedId,
                                                'section' => 'personal'
                                            ]) }}"
                                        class="bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 p-2 rounded-full hover:bg-indigo-200 dark:hover:bg-indigo-800 inline-flex items-center justify-center">
                                            <i data-lucide="edit"></i>
                                        </a>
                                        @endif

                                        {{-- Add other action buttons if needed --}}

                                        {{-- <button
                                            class="bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 p-2 rounded-full hover:bg-indigo-200 dark:hover:bg-indigo-800">
                                            <i data-lucide="phone-call"></i>
                                        </button> --}}
                                    </div>
                                </div>

                                <div class="mt-4 space-y-3">
                                    @php
                                        $teacherDetails = [
                                            ['icon' => 'user', 'label' => 'Full Name', 'value' => $teacher->name],
                                            ['icon' => 'calendar-days', 'label' => 'Date of Birth', 'value' => $teacher->birthDay ? \Carbon\Carbon::parse($teacher->personalinfo->birthDay)->format('F j, Y') : 'N/A'],
                                            ['icon' => 'map-pin', 'label' => 'Permanent Address', 'value' => trim("{$teacher->permAddress}", ', ')],
                                            ['icon' => 'map-pin', 'label' => 'Residential Address', 'value' => trim("{$teacher->tempAddress}", ', ')],
                                            ['icon' => 'mail', 'label' => 'Email', 'value' => $teacher->email ?? 'N/A'],
                                            ['icon' => 'phone-call', 'label' => 'Contact', 'value' => trim("{$teacher->mobile1} / WhatsApp: {$teacher->mobile2}", ' / ')],
                                        ];
                                    @endphp

                                    @foreach($teacherDetails as $detail)
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
                                        <div class="flex space-x-2">
                                            @if (Auth::user()->hasPermission('slts_personal_info_edit'))
                                            <a href="{{ route('teacher.profileedit', [
                                                    'id' => $teacher->cryptedId,
                                                    'section' => 'personal-info'
                                                ]) }}"
                                            class="bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 p-2 rounded-full hover:bg-indigo-200 dark:hover:bg-indigo-800 inline-flex items-center justify-center">
                                                <i data-lucide="edit"></i>
                                            </a>
                                            @endif

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
                                                <h4 class="font-medium text-gray-800 dark:text-gray-100">Race</h4>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $teacher->race }}</p>
                                            </div>
                                        </li>
                                        <li class="flex items-start">
                                            <div class="bg-indigo-100 dark:bg-indigo-900 p-2 rounded-full mr-3">
                                                <i data-lucide="graduation-cap"
                                                    class="text-indigo-600 dark:text-indigo-300 text-xs"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-800 dark:text-gray-100">Religion</h4>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $teacher->religion }}</p>
                                            </div>
                                        </li>
                                        <li class="flex items-start">
                                            <div class="bg-indigo-100 dark:bg-indigo-900 p-2 rounded-full mr-3">
                                                <i data-lucide="graduation-cap"
                                                    class="text-indigo-600 dark:text-indigo-300 text-xs"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-800 dark:text-gray-100">Civil Status</h4>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $teacher->civilStatus }}</p>
                                            </div>
                                        </li>
                                        <li class="flex items-start">
                                            <div class="bg-indigo-100 dark:bg-indigo-900 p-2 rounded-full mr-3">
                                                <i data-lucide="graduation-cap"
                                                    class="text-indigo-600 dark:text-indigo-300 text-xs"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-800 dark:text-gray-100">BirthDay</h4>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $teacher->birthDay }}</p>
                                            </div>
                                        </li>
                                        <li class="flex items-start">
                                            <div class="bg-indigo-100 dark:bg-indigo-900 p-2 rounded-full mr-3">
                                                <i data-lucide="graduation-cap"
                                                    class="text-indigo-600 dark:text-indigo-300 text-xs"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-800 dark:text-gray-100">Gender</h4>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $teacher->gender }}</p>
                                            </div>
                                        </li>
                                    </ul>

                                </div>

                                <!-- Location Info -->
                                <div>
                                    <h3
                                        class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-3 flex items-center">
                                        <i class="fas fa-graduation-cap text-indigo-600 dark:text-indigo-400 mr-2"></i>
                                        Location Info
                                        <div class="flex space-x-2">
                                            @if (Auth::user()->hasPermission('slts_location_edit'))
                                            <a href="{{ route('teacher.profileedit', [
                                                    'id' => $teacher->cryptedId,
                                                    'section' => 'location-info'
                                                ]) }}"
                                            class="bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 p-2 rounded-full hover:bg-indigo-200 dark:hover:bg-indigo-800 inline-flex items-center justify-center">
                                                <i data-lucide="edit"></i>
                                            </a>
                                            @endif

                                            {{-- Add other action buttons if needed --}}
                                            {{-- <button
                                                class="bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 p-2 rounded-full hover:bg-indigo-200 dark:hover:bg-indigo-800">
                                                <i data-lucide="phone-call"></i>
                                            </button> --}}
                                        </div>
                                    </h3>
                                    <ul class="space-y-3">
                                        <li class="flex items-start">
                                            <div class="p-2 rounded-full mr-3
                                                {{ $teacher->province ? 'bg-indigo-100 dark:bg-indigo-900' : 'bg-red-100 dark:bg-red-900' }}">

                                                @if($teacher->province)
                                                    <i data-lucide="check" class="text-indigo-600 dark:text-indigo-300 text-xs"></i>
                                                @else
                                                    <i data-lucide="x" class="text-red-600 dark:text-red-300 text-xs"></i>
                                                @endif
                                            </div>

                                            <div>
                                                <h4 class="font-medium text-gray-800 dark:text-gray-100">Province</h4>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm">
                                                    {{ $teacher->province ?? 'Not Available' }}
                                                </p>
                                            </div>
                                        </li>

                                        <li class="flex items-start">
                                            <div class="p-2 rounded-full mr-3
                                                {{ $teacher->district ? 'bg-indigo-100 dark:bg-indigo-900' : 'bg-red-100 dark:bg-red-900' }}">

                                                @if($teacher->district)
                                                    <i data-lucide="check" class="text-indigo-600 dark:text-indigo-300 text-xs"></i>
                                                @else
                                                    <i data-lucide="x" class="text-red-600 dark:text-red-300 text-xs"></i>
                                                @endif
                                            </div>

                                            <div>
                                                <h4 class="font-medium text-gray-800 dark:text-gray-100">District</h4>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm">
                                                    {{ $teacher->district ?? 'Not Available' }}
                                                </p>
                                            </div>
                                        </li>

                                        <li class="flex items-start">
                                            <div class="p-2 rounded-full mr-3
                                                {{ $teacher->dsDivision ? 'bg-indigo-100 dark:bg-indigo-900' : 'bg-red-100 dark:bg-red-900' }}">

                                                @if($teacher->dsDivision)
                                                    <i data-lucide="check" class="text-indigo-600 dark:text-indigo-300 text-xs"></i>
                                                @else
                                                    <i data-lucide="x" class="text-red-600 dark:text-red-300 text-xs"></i>
                                                @endif
                                            </div>

                                            <div>
                                                <h4 class="font-medium text-gray-800 dark:text-gray-100">DS Division</h4>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm">
                                                    {{ $teacher->dsDivision ?? 'Not Available' }}
                                                </p>
                                            </div>
                                        </li>

                                        <li class="flex items-start">
                                            <div class="p-2 rounded-full mr-3
                                                {{ $teacher->gnDivision ? 'bg-indigo-100 dark:bg-indigo-900' : 'bg-red-100 dark:bg-red-900' }}">

                                                @if($teacher->gnDivision)
                                                    <i data-lucide="check" class="text-indigo-600 dark:text-indigo-300 text-xs"></i>
                                                @else
                                                    <i data-lucide="x" class="text-red-600 dark:text-red-300 text-xs"></i>
                                                @endif
                                            </div>

                                            <div>
                                                <h4 class="font-medium text-gray-800 dark:text-gray-100">GN Division</h4>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm">
                                                    {{ $teacher->gnDivision ?? 'Not Available' }}
                                                </p>
                                            </div>
                                        </li>

                                        <li class="flex items-start">
                                            <div class="p-2 rounded-full mr-3
                                                {{ $teacher->educationDivision ? 'bg-indigo-100 dark:bg-indigo-900' : 'bg-red-100 dark:bg-red-900' }}">

                                                @if($teacher->educationDivision)
                                                    <i data-lucide="check" class="text-indigo-600 dark:text-indigo-300 text-xs"></i>
                                                @else
                                                    <i data-lucide="x" class="text-red-600 dark:text-red-300 text-xs"></i>
                                                @endif
                                            </div>

                                            <div>
                                                <h4 class="font-medium text-gray-800 dark:text-gray-100">Res. Education  Division</h4>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm">
                                                    {{ $teacher->educationDivision ?? 'Not Available' }}
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
                                    <h3
                                        class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-3 flex items-center">
                                        <i class="fas fa-graduation-cap text-indigo-600 dark:text-indigo-400 mr-2"></i>
                                        Rank Info
                                        <div class="flex space-x-2">
                                            @if (Auth::user()->hasPermission('slts_rank_edit'))
                                            <a href="{{ route('teacher.profileedit', [
                                                    'id' => $teacher->cryptedId,
                                                    'section' => 'rank-info'
                                                ]) }}"
                                            class="bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 p-2 rounded-full hover:bg-indigo-200 dark:hover:bg-indigo-800 inline-flex items-center justify-center">
                                                <i data-lucide="edit"></i>
                                            </a>
                                            @endif
                                            {{-- <button
                                                class="bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 p-2 rounded-full hover:bg-indigo-200 dark:hover:bg-indigo-800">
                                                <i data-lucide="phone-call"></i>
                                            </button> --}}
                                        </div>
                                    </h3>

                                    <ul class="space-y-3">
                                        @forelse($currentServiceRanks ?? [] as $rank)
                                            <li class="flex items-start">
                                                <!-- Left Icon -->
                                                <div class="bg-indigo-100 dark:bg-indigo-900 p-2 rounded-full mr-3">
                                                    <i data-lucide="medal" class="text-indigo-600 dark:text-indigo-300 text-xs"></i>
                                                </div>

                                                <!-- Right Content -->
                                                <div>
                                                    <h4 class="font-medium text-gray-800 dark:text-gray-100">
                                                        {{ $rank['rankName'] ?? 'Not Available' }}
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
                                    <h3
                                        class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-3 flex items-center">
                                        <i class="fas fa-graduation-cap text-indigo-600 dark:text-indigo-400 mr-2"></i>
                                        Family Info
                                        <div class="flex space-x-2">
                                            @if (Auth::user()->hasPermission('slts_family_edit'))
                                            <a href="{{ route('teacher.profileedit', [
                                                    'id' => $teacher->cryptedId,
                                                    'section' => 'family-info'
                                                ]) }}"
                                            class="bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 p-2 rounded-full hover:bg-indigo-200 dark:hover:bg-indigo-800 inline-flex items-center justify-center">
                                                <i data-lucide="edit"></i>
                                            </a>
                                            @endif
                                            {{-- <button
                                                class="bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 p-2 rounded-full hover:bg-indigo-200 dark:hover:bg-indigo-800">
                                                <i data-lucide="phone-call"></i>
                                            </button> --}}
                                        </div>
                                    </h3>

                                    @forelse($family as $member)
                                        <div class="text-gray-600 dark:text-gray-400 text-sm">
                                            <strong>{{ $member['relation'] }}</strong><br>
                                            Name: {{ $member['name'] ?? 'N/A' }}<br>
                                            NIC: {{ $member['nic'] ?? 'N/A' }}<br>
                                            Profession: {{ $member['profession'] ?? 'N/A' }}<br>
                                            School: {{ $member['school'] ?? 'N/A' }}<br>
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
                                    <h3
                                        class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-3 flex items-center">
                                        <i class="fas fa-graduation-cap text-indigo-600 dark:text-indigo-400 mr-2"></i>
                                        Education Qualification
                                        <div class="flex space-x-2">
                                            @if (Auth::user()->hasPermission('slts_education_edit'))
                                            <a href="{{ route('teacher.profileedit', [
                                                    'id' => $teacher->cryptedId,
                                                    'section' => 'education-info'
                                                ]) }}"
                                            class="bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 p-2 rounded-full hover:bg-indigo-200 dark:hover:bg-indigo-800 inline-flex items-center justify-center">
                                                <i data-lucide="edit"></i>
                                            </a>
                                            @endif
                                            {{-- <button
                                                class="bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 p-2 rounded-full hover:bg-indigo-200 dark:hover:bg-indigo-800">
                                                <i data-lucide="phone-call"></i>
                                            </button> --}}
                                        </div>
                                    </h3>

                                    <p class="text-gray-600 dark:text-gray-400 whitespace-pre-line">
                                        {{ $educationQualifications ?: 'No education qualifications available.' }}
                                    </p>
                                </div>

                                <div>
                                    <h3
                                        class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-3 flex items-center">
                                        <i class="fas fa-graduation-cap text-indigo-600 dark:text-indigo-400 mr-2"></i>
                                        Professional Qualification
                                        <div class="flex space-x-2">
                                            @if (Auth::user()->hasPermission('slts_professional_edit'))
                                            <a href="{{ route('teacher.profileedit', [
                                                    'id' => $teacher->cryptedId,
                                                    'section' => 'professional-info'
                                                ]) }}"
                                            class="bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 p-2 rounded-full hover:bg-indigo-200 dark:hover:bg-indigo-800 inline-flex items-center justify-center">
                                                <i data-lucide="edit"></i>
                                            </a>
                                            @endif
                                        </div>
                                    </h3>

                                    <p class="text-gray-600 dark:text-gray-400 whitespace-pre-line">
                                        {{ $professionalQualifications ?: 'No professional qualifications available.' }}
                                    </p>
                                </div>

                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-200 dark:border-gray-700"></div>

                        <!-- Teacher Service Details -->
                        <div class="p-6">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div>
                                    <h3
                                        class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-3 flex items-center">
                                        <i class="fas fa-graduation-cap text-indigo-600 dark:text-indigo-400 mr-2"></i>
                                        Teacher Service Info
                                        <div class="flex space-x-2">
                                            @if (Auth::user()->hasPermission('slts_personal_info_edit'))
                                            <a href="{{ route('teacher.profileedit', [
                                                    'id' => $teacher->cryptedId,
                                                    'section' => 'teacher-info'
                                                ]) }}"
                                            class="bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 p-2 rounded-full hover:bg-indigo-200 dark:hover:bg-indigo-800 inline-flex items-center justify-center">
                                                <i data-lucide="edit"></i>
                                            </a>
                                            @endif

                                        </div>
                                    </h3>
                                    <ul class="space-y-3">
                                        <li class="flex items-start">
                                            <div class="bg-indigo-100 dark:bg-indigo-900 p-2 rounded-full mr-3">
                                                <i data-lucide="graduation-cap"
                                                    class="text-indigo-600 dark:text-indigo-300 text-xs"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-800 dark:text-gray-100">Appointment Subject</h4>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm">
                                                    {{ optional($currentService->teacherService)->appointmentSubject->name ?? 'N/A' }}
                                                </p>
                                            </div>
                                        </li>
                                        <li class="flex items-start">
                                            <div class="bg-indigo-100 dark:bg-indigo-900 p-2 rounded-full mr-3">
                                                <i data-lucide="graduation-cap"
                                                    class="text-indigo-600 dark:text-indigo-300 text-xs"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-800 dark:text-gray-100">Main Subject</h4>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ optional($currentService->teacherService)->mainSubject->name ?? 'N/A' }}</p>
                                            </div>
                                        </li>
                                        <li class="flex items-start">
                                            <div class="bg-indigo-100 dark:bg-indigo-900 p-2 rounded-full mr-3">
                                                <i data-lucide="graduation-cap"
                                                    class="text-indigo-600 dark:text-indigo-300 text-xs"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-800 dark:text-gray-100">Appointment Medium</h4>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ optional($currentService->teacherService)->appointmentMedium->name ?? 'N/A' }}</p>
                                            </div>
                                        </li>
                                        <li class="flex items-start">
                                            <div class="bg-indigo-100 dark:bg-indigo-900 p-2 rounded-full mr-3">
                                                <i data-lucide="graduation-cap"
                                                    class="text-indigo-600 dark:text-indigo-300 text-xs"></i>
                                            </div>
                                            <div>
                                                <h4 class="font-medium text-gray-800 dark:text-gray-100">Appointment Category</h4>
                                                <p class="text-gray-600 dark:text-gray-400 text-sm">{{ optional($currentService->teacherService)->appointmentCategory->name ?? 'N/A' }}</p>
                                            </div>
                                        </li>
                                    </ul>

                                </div>

                                <div class="mt-8">
                                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-3 flex items-center">
                                        <i class="fas fa-briefcase text-indigo-600 dark:text-indigo-400 mr-2"></i>
                                        Services
                                        @if (Auth::user()->hasPermission('slts_rank_edit'))
                                            <a href="{{ route('teacher.profileedit', [
                                                    'id' => $teacher->cryptedId,
                                                    'section' => 'service-info'
                                                ]) }}"
                                            class="bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 p-2 rounded-full hover:bg-indigo-200 dark:hover:bg-indigo-800 inline-flex items-center justify-center">
                                                <i data-lucide="edit"></i>
                                            </a>
                                        @endif
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
                                                        Current Service: {{ $currentService->service?->name ?? 'Not Available' }}
                                                    </h4>
                                                    <p class="text-gray-600 dark:text-gray-400 text-sm ml-4">
                                                        Started on: {{ $currentService->appointedDate ?? 'Unknown' }}
                                                    </p>
                                                </div>
                                            </li>
                                        @else
                                            <li class="text-gray-500 dark:text-gray-400">No current service available.</li>
                                        @endif

                                        {{-- Previous Services --}}
                                        @forelse($previousServices as $service)
                                            <li class="flex items-start">
                                                <div class="bg-indigo-100 dark:bg-indigo-900 p-2 rounded-full mr-3">
                                                    <i data-lucide="clock" class="text-indigo-600 dark:text-indigo-300 text-xs"></i>
                                                </div>
                                                <div>
                                                    <h4 class="font-medium text-gray-800 dark:text-gray-100">
                                                        {{ $service->service?->name ?? 'Unknown Service' }}
                                                    </h4>
                                                    <p class="text-gray-600 dark:text-gray-400 text-sm ml-4">
                                                        From {{ $service->appointedDate ?? 'N/A' }} to {{ $service->releasedDate ?? 'Present' }}
                                                    </p>
                                                </div>
                                            </li>
                                        @empty
                                            <li class="text-gray-500 dark:text-gray-400">No previous services found.</li>
                                        @endforelse
                                    </ul>
                                </div>



                            </div>
                        </div>

                        <!-- Divider -->
                        <div class="border-t border-gray-200 dark:border-gray-700"></div>

                        <!-- Teacher Service Details -->
                        <div class="p-6">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="mt-8">
                                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-3 flex items-center">
                                        <i class="fas fa-user-tie text-indigo-600 dark:text-indigo-400 mr-2"></i>
                                        Appointments
                                        @if (Auth::user()->hasPermission('slts_appointment_edit'))
                                            <a href="{{ route('teacher.profileedit', [
                                                    'id' => $teacher->cryptedId,
                                                    'section' => 'appointment-info'
                                                ]) }}"
                                            class="bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 p-2 rounded-full hover:bg-indigo-200 dark:hover:bg-indigo-800 inline-flex items-center justify-center">
                                                <i data-lucide="edit"></i>
                                            </a>
                                        @endif
                                    </h3>

                                    <ul class="space-y-3">
                                        {{-- Current Appointments --}}
                                        @forelse($currentAppointments as $app)
                                            <li class="flex items-start">
                                                <div class="bg-green-100 dark:bg-green-900 p-2 rounded-full mr-3">
                                                    <i data-lucide="check" class="text-green-600 dark:text-green-300 text-xs"></i>
                                                </div>
                                                <div>
                                                    <h4 class="font-medium text-gray-800 dark:text-gray-100">
                                                        {{ $app['workPlace'] ?? 'Unknown Workplace' }}
                                                    </h4>
                                                    <p class="text-gray-600 dark:text-gray-400 text-sm ml-4">
                                                        From {{ $app['appointedDate'] ?? 'N/A' }}
                                                    </p>
                                                </div>
                                            </li>
                                        @empty
                                            <li class="text-gray-500 dark:text-gray-400">No current appointments available.</li>
                                        @endforelse

                                        {{-- Previous Appointments --}}
                                        @forelse($previousAppointments as $app)
                                            <li class="flex items-start">
                                                <div class="bg-indigo-100 dark:bg-indigo-900 p-2 rounded-full mr-3">
                                                    <i data-lucide="clock" class="text-indigo-600 dark:text-indigo-300 text-xs"></i>
                                                </div>
                                                <div>
                                                    <h4 class="font-medium text-gray-800 dark:text-gray-100">
                                                        {{ $app['workPlace'] ?? 'Unknown Workplace' }}
                                                    </h4>
                                                    <p class="text-gray-600 dark:text-gray-400 text-sm ml-4">
                                                        From {{ $app['appointedDate'] ?? 'N/A' }} to {{ $app['releasedDate'] ?? 'Present' }}
                                                    </p>
                                                </div>
                                            </li>
                                        @empty
                                            <li class="text-gray-500 dark:text-gray-400">No previous appointments available.</li>
                                        @endforelse

                                        {{-- Current Appointments --}}
                                        @forelse($currentAttachedAppointments as $app)
                                            <li class="flex items-start">
                                                <div class="bg-green-100 dark:bg-green-900 p-2 rounded-full mr-3">
                                                    <i data-lucide="check" class="text-green-600 dark:text-green-300 text-xs"></i>
                                                </div>
                                                <div>
                                                    <h4 class="font-medium text-gray-800 dark:text-gray-100">
                                                        {{ $app['workPlace']."(Attached)" ?? 'Unknown Workplace' }}
                                                    </h4>
                                                    <p class="text-gray-600 dark:text-gray-400 text-sm ml-4">
                                                        From {{ $app['appointedDate'] ?? 'N/A' }}
                                                    </p>
                                                </div>
                                            </li>
                                        @empty
                                            <li class="text-gray-500 dark:text-gray-400">No current Attached appointments available.</li>
                                        @endforelse

                                        {{-- Previous Appointments --}}
                                        @forelse($previousAttachedAppointments as $app)
                                            <li class="flex items-start">
                                                <div class="bg-indigo-100 dark:bg-indigo-900 p-2 rounded-full mr-3">
                                                    <i data-lucide="clock" class="text-indigo-600 dark:text-indigo-300 text-xs"></i>
                                                </div>
                                                <div>
                                                    <h4 class="font-medium text-gray-800 dark:text-gray-100">
                                                        {{ $app['workPlace']."(Attached)" ?? 'Unknown Workplace' }}
                                                    </h4>
                                                    <p class="text-gray-600 dark:text-gray-400 text-sm ml-4">
                                                        From {{ $app['appointedDate'] ?? 'N/A' }} to {{ $app['releasedDate'] ?? 'Present' }}
                                                    </p>
                                                </div>
                                            </li>
                                        @empty
                                            <li class="text-gray-500 dark:text-gray-400">No previous Attached appointments available.</li>
                                        @endforelse
                                    </ul>
                                </div>
                                <div class="mt-8">
                                    <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-3 flex items-center">
                                        <i class="fas fa-id-badge text-indigo-600 dark:text-indigo-400 mr-2"></i>
                                        Positions
                                        @if (Auth::user()->hasPermission('slts_position_edit'))
                                            <a href="{{ route('teacher.profileedit', [
                                                    'id' => $teacher->cryptedId,
                                                    'section' => 'position-info'
                                                ]) }}"
                                            class="bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 p-2 rounded-full hover:bg-indigo-200 dark:hover:bg-indigo-800 inline-flex items-center justify-center ml-2">
                                                <i data-lucide="edit"></i>
                                            </a>
                                        @endif
                                    </h3>
                                    <ul>
                                        @forelse($currentAppointments as $app)
                                            @if(!empty($app['currentPositions']))
                                                @foreach($app['currentPositions'] as $pos)
                                                    <li class="flex items-start mb-3">
                                                        <div class="bg-green-100 dark:bg-green-900 p-2 rounded-full mr-3">
                                                            <i data-lucide="check" class="text-green-600 dark:text-green-300 text-xs"></i>
                                                        </div>
                                                        <div>
                                                            <h4 class="font-bold text-lg text-gray-800 dark:text-gray-100">
                                                                {{ $pos['positionName'] ?? 'Unknown Position' }}
                                                            </h4>
                                                            <p class="text-gray-600 dark:text-gray-400 text-sm ml-1">
                                                                Workplace: {{ $app['workPlace'] ?? 'Unknown' }}<br>
                                                                Positioned Date: {{ $pos['positionedDate'] ?? 'N/A' }}
                                                            </p>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            @endif
                                        @empty
                                            <li class="text-gray-500 dark:text-gray-400">No current positions available.</li>
                                        @endforelse
                                    </ul>
                                    <ul>
                                        @forelse($previousAppointments as $app)
                                            @if(!empty($app['positions']))
                                                @foreach($app['positions'] as $pos)
                                                    <li class="flex items-start mb-3">
                                                        <div class="bg-yellow-100 dark:bg-yellow-900 p-2 rounded-full mr-3">
                                                            <i data-lucide="clock" class="text-yellow-600 dark:text-yellow-300 text-xs"></i>
                                                        </div>
                                                        <div>
                                                            <h4 class="font-bold text-lg text-gray-800 dark:text-gray-100">
                                                                {{ $pos['positionName'] ?? 'Unknown Position' }}
                                                            </h4>
                                                            <p class="text-gray-600 dark:text-gray-400 text-sm ml-1">
                                                                Workplace: {{ $app['workPlace'] ?? 'Unknown' }}<br>
                                                                Positioned Date: {{ $pos['positionedDate'] ?? 'N/A' }}<br>
                                                                {{-- Released Date: {{ $pos['releasedDate'] ?? $app['releasedDate'] ?? 'N/A' }} --}}
                                                            </p>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            @endif
                                        @empty
                                            <li class="text-gray-500 dark:text-gray-400">No previous positions available.</li>
                                        @endforelse
                                    </ul>
                                    <ul>
                                        @forelse($currentAttachedAppointments as $app)
                                            @if(!empty($app['positions']))
                                                @foreach($app['positions'] as $pos)
                                                    <li class="flex items-start mb-3">
                                                        <div class="bg-blue-100 dark:bg-blue-900 p-2 rounded-full mr-3">
                                                            <i data-lucide="link" class="text-blue-600 dark:text-blue-300 text-xs"></i>
                                                        </div>
                                                        <div>
                                                            <h4 class="font-bold text-lg text-gray-800 dark:text-gray-100">
                                                                {{ $pos['positionName'] ?? 'Unknown Position' }}
                                                            </h4>
                                                            <p class="text-gray-600 dark:text-gray-400 text-sm ml-1">
                                                                Workplace: {{ $app['workPlace'] ?? 'Unknown' }}<br>
                                                                Positioned Date: {{ $pos['positionedDate'] ?? 'N/A' }}
                                                            </p>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            @endif
                                        @empty
                                            <li class="text-gray-500 dark:text-gray-400">No current attached positions available.</li>
                                        @endforelse
                                    </ul>
                                    <ul>
                                        @forelse($previousAttachedAppointments as $app)
                                            @if(!empty($app['positions']))
                                                @foreach($app['positions'] as $pos)
                                                    <li class="flex items-start mb-3">
                                                        <div class="bg-red-100 dark:bg-red-900 p-2 rounded-full mr-3">
                                                            <i data-lucide="unlink" class="text-red-600 dark:text-red-300 text-xs"></i>
                                                        </div>
                                                        <div>
                                                            <h4 class="font-bold text-lg text-gray-800 dark:text-gray-100">
                                                                {{ $pos['positionName'] ?? 'Unknown Position' }}
                                                            </h4>
                                                            <p class="text-gray-600 dark:text-gray-400 text-sm ml-1">
                                                                Workplace: {{ $app['workPlace'] ?? 'Unknown' }}<br>
                                                                Positioned Date: {{ $pos['positionedDate'] ?? 'N/A' }}<br>
                                                                {{-- Released Date: {{ $pos['releasedDate'] ?? $app['releasedDate'] ?? 'N/A' }} --}}
                                                            </p>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            @endif
                                        @empty
                                            <li class="text-gray-500 dark:text-gray-400">No previous attached positions available.</li>
                                        @endforelse
                                    </ul>
                                </div>


                            </div>
                        </div>
                        <!-- Divider -->
                        <div class="border-t border-gray-200 dark:border-gray-700"></div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
