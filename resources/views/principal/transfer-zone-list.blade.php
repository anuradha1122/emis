<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumb :list="$option" />
            <div class="isolate bg-white px-6 py-10 sm:py-10 lg:px-8">
                <x-form-success message="{{ session('success') }}" />
                <x-form-heading heading="PRINCIPAL TRANSFER" subheading="Transfer Requested Principal List" />
                <div class="relative flex flex-col w-full h-full text-gray-700 bg-white shadow-md rounded-xl bg-clip-border">
                    <div class="p-6 px-0 overflow-scroll">
                        <table class="w-full mt-4 text-left table-auto min-w-max">
                            <thead>
                                <tr>
                                    <x-table-heading heading="Status" />
                                    <x-table-heading heading="Confirm" />
                                    <x-table-heading heading="Name/School" />
                                    <x-table-heading heading="Decision" />
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($principals as $principal)
                                <tr>
                                    @if ($principal->zonalId== NULL)
                                        <x-table-status-detail text="require" bgColor="bg-red-100" textColor="text-red-800" />
                                    @else
                                        <x-table-status-detail text="done" bgColor="bg-green-100" textColor="text-green-800" />
                                    @endif

                                    <x-table-action action="1" link="principal.transferzonalprofile" :params="['id' => $principal->refferenceNo]" />

                                    <x-table-heading-detail
                                        heading="{!! $principal->nic.': '.$principal->principal.'<br>'.$principal->workPlace !!}"
                                        d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 2c4.411 0 8 3.589 8 8s-3.589 8-8 8-8-3.589-8-8 3.589-8 8-8zm0 1.75a2.5 2.5 0 100 5 2.5 2.5 0 000-5zM12 9a1 1 0 110-2 1 1 0 010 2zm0 4.75c-2.347 0-4.444 1.003-5.716 2.574-.24.292-.051.676.351.676h10.73c.402 0 .591-.384.351-.676C16.444 14.753 14.347 13.75 12 13.75z"
                                        link="principal.profileedit"
                                    />

                                        @php
                                        if (is_null($principal->zonalId)) {
                                            $text = 'Pending';
                                        } else {
                                            $reasonMapping = [
                                                'zonalReason1' => [
                                                    1 => 'The service of this principal has been confirmed.',
                                                    2 => 'The service of this principal has not been confirmed.',
                                                ],
                                                'zonalReason2' => [
                                                    1 => 'There are disciplinary or audit queries against this principal.',
                                                    2 => 'There aren’t disciplinary or audit queries against this principal.',
                                                ],
                                                'zonalReason3' => [
                                                    1 => 'This principal is Supernumeric',
                                                    2 => 'This principal is Principal Graded.',
                                                ],
                                                'zonalReason4' => [
                                                    1 => 'This principal can be released with a successor',
                                                    2 => 'This principal can be released without a successor.',
                                                ],
                                            ];

                                            $reasons = [
                                                'zonalReason1' => $principal->zonalReason1,
                                                'zonalReason2' => $principal->zonalReason2,
                                                'zonalReason3' => $principal->zonalReason3,
                                                'zonalReason4' => $principal->zonalReason4,
                                            ];

                                            $text = collect($reasons)
                                                ->map(fn($value, $key) => $value ? ($reasonMapping[$key][$value] ?? 'Unknown') : null)
                                                ->filter()
                                                ->join('<br>'); // join with line break
                                        }
                                        @endphp

                                        <x-table-text-detail :text="$text" />


                                </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
