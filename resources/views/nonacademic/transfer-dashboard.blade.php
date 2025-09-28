<x-app-layout>

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumb :list="$option" />
            <div class="isolate bg-white px-6 py-10 sm:py-10 lg:px-8">
                <x-form-heading heading="TEACHER TRANSFER PORTAL" subheading="Apply for transfer" />

                {{-- Center the button --}}
                <div class="flex justify-center mt-6">
                    @if($years>=3)
                    <a href="{{ route('teacher.transfer') }}"
                        class="inline-block px-6 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition">
                        Apply
                    </a>
                    @else
                    <p class="text-red-900">You are not eligible for annual transfer</p>
                    @endif
                </div>
                <x-form-heading heading="" subheading="Transfer Application Status" />
            </div>
        </div>
    </div>

    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div> --}}
</x-app-layout>
