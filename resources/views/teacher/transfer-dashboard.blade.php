<x-app-layout>

    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumb :list="$option" />
            <div class="isolate bg-white px-6 py-10 sm:py-10 lg:px-8">
                <x-form-heading heading="TEACHER TRANSFER PORTAL" subheading="Transfer Status" />

                {{-- Center the button --}}
                {{-- <div class="flex justify-center mt-6">
                    @if($years>=3)
                    <a href="{{ route('teacher.transfer') }}"
                        class="inline-block px-6 py-2 bg-blue-600 text-white font-semibold rounded hover:bg-blue-700 transition">
                        Apply
                    </a>
                    @else
                    <p class="text-red-900">You are not eligible for annual transfer</p>
                    @endif
                </div> --}}

                <div class="flex flex-col">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>

                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($transfers as $transfer)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $transfer->typeName }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800"><a href="{{ url('/teacher-transfers-pdf') }}?typeId={{ $transfer->typeId }}" target="_blank">Download PDF</a></td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">Principal Recommendation</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $transfer->principalReasonText }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">Zonal Recommendation</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                                @if (
                                                    $transfer->zonalReason1Text === 'Pending' ||
                                                    $transfer->zonalReason2Text === 'Pending' ||
                                                    $transfer->zonalReason3Text === 'Pending' ||
                                                    $transfer->zonalReason4Text === 'Pending'
                                                )
                                                    Pending
                                                @else
                                                    <ul>
                                                        <li>{{ $transfer->zonalReason1Text }}</li>
                                                        <li>{{ $transfer->zonalReason2Text }}</li>
                                                        <li>{{ $transfer->zonalReason3Text }}</li>
                                                        <li>{{ $transfer->zonalReason4Text }}</li>
                                                    </ul>
                                                @endif
                                            </td>

                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">Provincial Recommendation</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">Pending</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
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
