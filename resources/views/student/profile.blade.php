<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumb :list="$option" />
            <div class="isolate bg-white px-6 py-10 sm:py-10 lg:px-8">
                <x-profile-heading heading="{{ $student->nameWithInitials }}" subHeading="{{ $student->studentNo }}" image="{{ $student->profilePicture }}" />

                <div class="border-t border-gray-200">
                    @livewire('student-profile',
                    [
                        'student' => $student,
                    ])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>