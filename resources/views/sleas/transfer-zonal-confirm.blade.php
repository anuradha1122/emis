<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumb :list="$option" />
            <x-form-success message="{{ session('success') }}" />
            <x-profile-heading heading="{{ $teacher->teacher }}" subHeading="{{ $teacher->nic }}" image="" />
            <div class="grid grid-cols-1 place-items-center gap-y-6">
                <div class="w-full max-w-4xl">
                    <div class="overflow-x-auto">
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden shadow rounded-lg border border-gray-200">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            @if (!empty($results))
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Detail</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">Reference No</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $teacher->refferenceNo }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">Name</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $teacher->teacher }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">Transfer Type</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $teacher->transfer_type }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">NIC</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $teacher->nic }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">Transfer Reason</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $teacher->reason }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">School 1</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $teacher->workPlace1 }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">School 2</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $teacher->workPlace2 }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">School 3</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $teacher->workPlace3 }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">School 4</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $teacher->workPlace4 }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">School 5</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $teacher->workPlace5 }}</td>
                                        </tr>

                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">Alternative School 1</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $teacher->alterWorkPlace1 }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">Alternative School 2</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $teacher->alterWorkPlace2 }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">Alternative School 3</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $teacher->alterWorkPlace3 }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">Alternative School 4</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $teacher->alterWorkPlace4 }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">Alternative School 5</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $teacher->alterWorkPlace5 }}</td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">Principal Decision</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ $teacher->principalReasonText }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('teacher.transferzonalprofilestore') }}" class="mx-auto mt-8 max-w-xl sm:mt-8" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-6">


                    <x-form-list-input-section size="sm:col-span-6" name="decision1" id="decision1" :options="$decision1" label="Select Decision 1" />
                    <x-form-list-input-section size="sm:col-span-6" name="decision2" id="decision2" :options="$decision2" label="Select Decision 2" />
                    <x-form-list-input-section size="sm:col-span-6" name="decision3" id="decision3" :options="$decision3" label="Select Decision 3" />
                    <x-form-list-input-section size="sm:col-span-6" name="decision4" id="decision4" :options="$decision4" label="Select Decision 4" />
                    <input type="hidden" name="referenceNo" value="{{ $referenceNo }}">
                    <span class="sm:col-span-6">
                    <x-form-success message="{{ session('success') }}" />
                    </span>
                </div>
                <div class="mt-10">
                    <x-form-button-primary size="" text="Submit" modelBinding=""/>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>