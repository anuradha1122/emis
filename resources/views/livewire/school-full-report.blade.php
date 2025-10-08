<div>

    <form wire:submit.prevent="exportExcel" enctype="multipart/form-data">
        @csrf
        <div class="w-full grid grid-cols-1 gap-y-1 sm:grid-cols-4">
            @if (auth()->user()->workplaceType() == 'ministry')
                <div class="sm:col-span-1 px-1">
                    <x-form-input-label for="province" value="Province" />
                    <x-form-list-input-field name="province" id="province" :options="$provinceList" wire:model.live="selectedProvince"/>
                </div>
                <div class="sm:col-span-1 px-1">
                    <x-form-input-label for="district" value="District" />
                    <x-form-list-input-field name="district" id="district" :options="$districtList" wire:model.live="selectedDistrict"/>
                </div>
                <div class="sm:col-span-1 px-1">
                    <x-form-input-label for="zone" value="Zone" />
                    <x-form-list-input-field name="zone" id="zone" :options="$zoneList" wire:model.live="selectedZone"/>
                </div>
                <div class="sm:col-span-1 px-1">
                    <x-form-input-label for="division" value="Division" />
                    <x-form-list-input-field name="division" id="division" :options="$divisionList" wire:model.live="selectedDivision"/>
                </div>
            @elseif (auth()->user()->workplaceType() == 'provincial_department')
                <div class="sm:col-span-1 px-1">
                    <x-form-input-label for="district" value="District" />
                    <x-form-list-input-field name="district" id="district" :options="$districtList" wire:model.live="selectedDistrict"/>
                </div>
                <div class="sm:col-span-1 px-1">
                    <x-form-input-label for="zone" value="Zone" />
                    <x-form-list-input-field name="zone" id="zone" :options="$zoneList" wire:model.live="selectedZone"/>
                </div>
                <div class="sm:col-span-1 px-1">
                    <x-form-input-label for="division" value="Division" />
                    <x-form-list-input-field name="division" id="division" :options="$divisionList" wire:model.live="selectedDivision"/>
                </div>
            @elseif (auth()->user()->workplaceType() == 'zone')
                <div class="sm:col-span-1 px-1">
                    <x-form-input-label for="division" value="Division" />
                    <x-form-list-input-field name="division" id="division" :options="$divisionList" wire:model.live="selectedDivision"/>
                </div>
            @elseif (auth()->user()->workplaceType() == 'division')
            @endif
            <div class="sm:col-span-1 px-1">
                <x-form-input-label for="schoolAuthority" value="School Authority" />
                <x-form-list-input-field name="schoolAuthority" id="schoolAuthority" :options="$schoolAuthorityList" wire:model.live="schoolAuthority"/>
            </div>
            <div class="sm:col-span-1 px-1">
                <x-form-input-label for="schoolEthnicity" value="School Ethnicity" />
                <x-form-list-input-field name="schoolEthnicity" id="schoolEthnicity" :options="$schoolEthnicityList" wire:model.live="schoolEthnicity"/>
            </div>
            <div class="sm:col-span-1 px-1">
                <x-form-input-label for="schoolClass" value="School Classes" />
                <x-form-list-input-field name="schoolClass" id="schoolClass" :options="$schoolClassList" wire:model.live="schoolClass"/>
            </div>
            <div class="sm:col-span-1 px-1">
                <x-form-input-label for="schoolDensity" value="School Densities" />
                <x-form-list-input-field name="schoolDensity" id="schoolDensity" :options="$schoolDensityList" wire:model.live="schoolDensity"/>
            </div>
            <div class="sm:col-span-1 px-1">
                <x-form-input-label for="schoolFacility" value="School Facilities" />
                <x-form-list-input-field name="schoolFacility" id="schoolFacility" :options="$schoolFacilityList" wire:model.live="schoolFacility"/>
            </div>
            <div class="sm:col-span-1 px-1">
                <x-form-input-label for="schoolGender" value="School Gender" />
                <x-form-list-input-field name="schoolGender" id="schoolGender" :options="$schoolGenderList" wire:model.live="schoolGender"/>
            </div>
            <div class="sm:col-span-1 px-1">
                <x-form-input-label for="schoolLanguage" value="School Languages" />
                <x-form-list-input-field name="schoolLanguage" id="schoolLanguage" :options="$schoolLanguageList" wire:model.live="schoolLanguage"/>
            </div>

        </div>
        {{-- Show which button was pressed --}}
        <div class="flex items-center justify-start gap-2 mx-4">
            <button type="button" wire:click="$set('reportAction','web')"
                class="mt-4 p-2 transition duration-200 bg-blue-500 hover:bg-blue-600 focus:bg-blue-700
                       focus:shadow-sm focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50
                       text-white rounded-lg text-sm shadow-sm hover:shadow-md font-semibold">
                Get Web
            </button>

            {{-- <button class="mt-4 p-2 transition duration-200 bg-green-500 hover:bg-green-600 focus:bg-green-700
                focus:shadow-sm focus:ring-4 focus:ring-green-500 focus:ring-opacity-50
                text-white rounded-lg text-sm shadow-sm hover:shadow-md font-semibold">
                    Export Excel
            </button> --}}

            <a href="{{ route('school.fullreport') }}" class="mt-4 p-2 transition duration-200 bg-white hover:bg-white focus:bg-white
                focus:shadow-sm focus:ring-4 focus:ring-white focus:ring-opacity-50
                text-black rounded-lg text-sm shadow-sm hover:shadow-md font-semibold">
                    Refresh
            </a>
        </div>
    </form>
    <div class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                    <tr>
                        @if ($results && $results->count() > 0)
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-800 dark:text-gray-200 uppercase">#</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-800 dark:text-gray-200 uppercase">CensusNo</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-800 dark:text-gray-200 uppercase">Name</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-800 dark:text-gray-200 uppercase">Authority</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-800 dark:text-gray-200 uppercase">Facility</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">

                        @foreach ($results as $index => $result)
                        <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white ">{{ $results->firstItem() + $index }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white">{{ $result->censusNo }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white">{{ $result->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white">
                            {{ $result->school->authority->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white">
                            {{ $result->school->facility->name ?? 'N/A' }}
                        </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
        <div class="mt-4 text-start">
            @if ($results instanceof \Illuminate\Pagination\AbstractPaginator)
                {{ $results->links() }}
            @endif
        </div>
    </div>
</div>
