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
                <div class="sm:col-span-1 px-1">
                    <x-form-input-label for="school" value="School" />
                    <x-form-list-input-field name="school" id="school" :options="$schoolList" wire:model.live="selectedSchool"/>
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
                <div class="sm:col-span-1 px-1">
                    <x-form-input-label for="school" value="School" />
                    <x-form-list-input-field name="school" id="school" :options="$schoolList" wire:model.live="selectedSchool"/>
                </div>
            @elseif (auth()->user()->workplaceType() == 'zone')
                <div class="sm:col-span-1 px-1">
                    <x-form-input-label for="division" value="Division" />
                    <x-form-list-input-field name="division" id="division" :options="$divisionList" wire:model.live="selectedDivision"/>
                </div>
                <div class="sm:col-span-1 px-1">
                    <x-form-input-label for="school" value="School" />
                    <x-form-list-input-field name="school" id="school" :options="$schoolList" wire:model.live="selectedSchool"/>
                </div>
            @elseif (auth()->user()->workplaceType() == 'division')
                <div class="sm:col-span-1 px-1">
                    <x-form-input-label for="school" value="School" />
                    <x-form-list-input-field name="school" id="school" :options="$schoolList" wire:model.live="selectedSchool"/>
                </div>
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
            <div class="sm:col-span-1 px-1">
                <x-form-input-label for="race" value="Race" />
                <x-form-list-input-field name="race" id="race" :options="$raceList" wire:model.live="race"/>
            </div>
            <div class="sm:col-span-1 px-1">
                <x-form-input-label for="religion" value="Religion" />
                <x-form-list-input-field name="religion" id="religion" :options="$religionList" wire:model.live="religion"/>
            </div>
            <div class="sm:col-span-1 px-1">
                <x-form-input-label for="civilStatus" value="Civil Status" />
                <x-form-list-input-field name="civilStatus" id="civilStatus" :options="$civilStatusList" wire:model.live="civilStatus"/>
            </div>
            <div class="sm:col-span-1 px-1">
                <x-form-input-label for="gender" value="Gender" />
                <x-form-list-input-field name="gender" id="gender" :options="$genderList" wire:model.live="gender"/>
            </div>
            <div class="sm:col-span-1 px-1">
                <x-form-input-label for="birthDay" value="Birth Day Start From" />
                <x-form-date-input-field name="birthDay" id="birthDay" wire:model.live="birthDayStart"/>
            </div>
            <div class="sm:col-span-1 px-1">
                <x-form-input-label for="birthDay" value="Birth Day To" />
                <x-form-date-input-field name="birthDay" id="birthDay" wire:model.live="birthDayEnd"/>
            </div>
            <div class="sm:col-span-1 px-1">
                <x-form-input-label for="service" value="Service Start From" />
                <x-form-date-input-field name="service" id="service" wire:model.live="serviceStart"/>
            </div>
            <div class="sm:col-span-1 px-1">
                <x-form-input-label for="service" value="Service To" />
                <x-form-date-input-field name="service" id="service" wire:model.live="serviceEnd"/>
            </div>
            <div class="sm:col-span-1 px-1">
                <x-form-input-label for="schoolAppoint" value="School Appoint Start From" />
                <x-form-date-input-field name="schoolAppoint" id="schoolAppoint" wire:model.live="schoolAppointStart"/>
            </div>
            <div class="sm:col-span-1 px-1">
                <x-form-input-label for="schoolAppoint" value="School Appoint To" />
                <x-form-date-input-field name="schoolAppoint" id="schoolAppoint" wire:model.live="schoolAppointEnd"/>
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

            <button class="mt-4 p-2 transition duration-200 bg-green-500 hover:bg-green-600 focus:bg-green-700
                focus:shadow-sm focus:ring-4 focus:ring-green-500 focus:ring-opacity-50
                text-white rounded-lg text-sm shadow-sm hover:shadow-md font-semibold">
                    Export Excel
            </button>

            <a href="{{ route('teacher.fullreport') }}" class="mt-4 p-2 transition duration-200 bg-white hover:bg-white focus:bg-white
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
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-800 dark:text-gray-200 uppercase">NIC</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-800 dark:text-gray-200 uppercase">Name With Initials</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-800 dark:text-gray-200 uppercase">School</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-800 dark:text-gray-200 uppercase">Gender</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-800 dark:text-gray-200 uppercase">Service Started</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-800 dark:text-gray-200 uppercase">Current Appointment Started</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">

                        @foreach ($results as $index => $result)
                        <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white ">{{ $results->firstItem() + $index }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white">{{ $result->nic }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white">{{ $result->nameWithInitials }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white">{{ $result->currentPrincipalService?->currentAppointment?->workPlace?->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white">
                            @if($result->personalInfo?->genderId == 1)
                                Male
                            @elseif($result->personalInfo?->genderId == 2)
                                Female
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white">{{ $result->currentPrincipalService?->appointedDate }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white">{{ $result->currentPrincipalService?->currentAppointment?->appointedDate }}</td>
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
