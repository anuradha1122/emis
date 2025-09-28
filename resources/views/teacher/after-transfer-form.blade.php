<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="isolate bg-white px-6 py-10 sm:py-10 lg:px-8">
                <x-form-heading heading="TRANSFER SUBMITTED SUCCESSFULL" subheading="Your PDF can be download here" />
                <x-form-heading heading="" subheading="Expect to apply for the annual teacher transfer." />

                {{-- Center the button --}}
                <div class="flex justify-center mt-6">
                    <a href="{{ route('teacher.transfer') }}"
                        class="inline-block px-6 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition">
                        Back
                    </a>
                    <a href="{{ url('/teacher-transfers-pdf') }}?typeId={{ $typeId }}" target="_blank"
                    class="mx-2 inline-block px-6 py-2 bg-red-600 text-white font-semibold rounded hover:bg-red-700 transition">
                        Download PDF
                    </a>

                </div>

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
