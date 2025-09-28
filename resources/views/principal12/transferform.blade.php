<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumb :list="$option" />
            <div class="isolate bg-white px-6 py-10 sm:py-10 lg:px-8">
                <x-form-heading heading="ANNUAL PRINCIPAL TRANSFER - 2025" subheading="TRANSFER APPLICATION" />
                <x-form-success message="{{ session('success') }}" />
                <form method="POST" action="{{ route('principal.transferstore') }}" class="mx-auto mt-8 max-w-xl sm:mt-8" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-6">
                        {{-- @livewire('library-book-search') --}}

                        {{-- @error('book') <span class="text-red-500">{{ $message }}</span> @enderror --}}

                        <span class="sm:col-span-6">ADDITIONAL PERSONAL DETAILS</span>

                        <x-form-text-input-section size="sm:col-span-6" name="appointmentLetterNo" id="appointmentLetterNo" label="1. First appointment letter no මුල් පත්වීම් ලිපි අංකය" value="{{ old('appointmentLetterNo') }}" />

                        <x-form-list-input-section size="sm:col-span-3" name="serviceConfirm" id="serviceConfirm" :options="$binaryList" label=" Is the service permenented සේවය ස්තීර කර තිබේද ? :" />

                        <x-form-text-input-section size="sm:col-span-3" name="schoolDistance" id="schoolDistance" label="Distance from permanent residence to the present school ස්ථිර පදිංචියේ සිට දැනට සේවය කරන පාසලට ඇති දුර (km)" value="{{ old('schoolDistance') }}" />

                        <x-form-list-input-section size="sm:col-span-3" name="position" id="position" :options="$positionList" label="Current school position දැනට සේවය කරන පාසලේ තනතුර" />

                        <x-form-list-input-section size="sm:col-span-3" name="specialChildren" id="specialChildren" :options="$binaryList" label="Have children with special needs විශේෂ අවශ්‍යතා ඇති දරුවන් සිටීද ?" />

                        <span class="sm:col-span-6">TRANSFER DETAILS</span>

                        <x-form-list-input-section size="sm:col-span-6" name="expectTransfer" id="expectTransfer" :options="$binaryList" label="Are you looking for a transfer ඔබ ස්ථාන මාරුවක් අපේක්ෂා කරන්නේද ?" />

                        <x-form-text-input-section size="sm:col-span-6" name="reason" id="reason" label="Reasons for requesting transfer or not ස්ථාන මාරුව ඉල්ලුම් කිරීමට හෝ නොකිරීමට හේතු " value="{{ old('reason') }}" />
                        <span class="sm:col-span-6">@livewire('principal-transfer-school')</span>
                        {{-- <span class="sm:col-span-6">2. Expected Schools to be Transferred ස්ථාන මාරුවීම් අපේක්ෂිත පාසල් :</span>
                            <span class="sm:col-span-6">@livewire('formUserSchool')</span>
                            <x-form-text-input-section size="sm:col-span-6" name="addressLine2" id="addressLine2" label="Distance from permanent residence to the requiested school ස්ථිර පදිංචියේ සිට පාසලට ඇති දුර (km):" value="{{ old('addressLine2') }}" />

                            <span class="sm:col-span-6">@livewire('formUserSchool')</span>
                            <x-form-text-input-section size="sm:col-span-6" name="addressLine2" id="addressLine2" label="Distance from permanent residence to the requiested school ස්ථිර පදිංචියේ සිට පාසලට ඇති දුර (km):" value="{{ old('addressLine2') }}" />

                            <span class="sm:col-span-6">@livewire('formUserSchool')</span>
                            <x-form-text-input-section size="sm:col-span-6" name="addressLine2" id="addressLine2" label="Distance from permanent residence to the requiested school ස්ථිර පදිංචියේ සිට පාසලට ඇති දුර (km):" value="{{ old('addressLine2') }}" />

                            <span class="sm:col-span-6">@livewire('formUserSchool')</span>
                            <x-form-text-input-section size="sm:col-span-6" name="addressLine2" id="addressLine2" label="Distance from permanent residence to the requiested school ස්ථිර පදිංචියේ සිට පාසලට ඇති දුර (km):" value="{{ old('addressLine2') }}" />

                            <span class="sm:col-span-6">@livewire('formUserSchool')</span>
                            <x-form-text-input-section size="sm:col-span-6" name="addressLine2" id="addressLine2" label="Distance from permanent residence to the requiested school ස්ථිර පදිංචියේ සිට පාසලට ඇති දුර (km):" value="{{ old('addressLine2') }}" /> --}}


                        <x-form-list-input-section size="sm:col-span-6" name="otherSchool" id="otherSchool" :options="$binaryList" label="4. If there aren’t vacancies in the requested zone, do you like to be transferred to any school in the requested zone අපේක්ෂිත පාසල්වල පුරප්පාඩු නොමැති නම් ඉල්ලා ඇති කලාපයේ වෙනත් ඕනෑම පාසලකට ස්ථානමාරුව ලබා ගැනීමට කැමතිද" />

                        <x-form-text-input-section size="sm:col-span-6" name="mention" id="mention" label="7. If you have anything else to mention, please mention it in this column ඔබට සඳහන් කිරීමට වෙනත් යමක් ඇත්නම්, කරුණාකර එය මෙම තීරුවේ සඳහන් කරන්න" value="{{ old('mention') }}" />


                        <span class="sm:col-span-6">I hereby certify that the above facts are true and correct. I know that providing false or incorrect information is a punishable offence ඉහත සඳහන් කරුණු සත්‍ය බවත් නිවැරදි බවත් මෙයින් සහතික කරමි. අසත්‍ය හෝ වැරදි තොරතුරක් සඳහන් කිරීම විනයානුකූලව දඬුවම් ලැබිය හැකි වරදක් බව දනිමි.</span>

                    </div>
                    <div class="mt-10">
                        <x-form-button-primary size="" text="Submit" modelBinding=""/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
