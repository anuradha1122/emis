<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumb :list="$option" />
            <div class="isolate bg-white px-6 py-10 sm:py-10 lg:px-8">
                <x-form-heading heading="ANNUAL TEACHER TRANSFER - 2025" subheading="TRANSFER APPLICATION" />
                <x-form-success message="{{ session('success') }}" />
                <form method="POST" action="{{ route('teacher.transferstore') }}" class="mx-auto mt-8 max-w-xl sm:mt-8" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-6">
                        {{-- @livewire('library-book-search') --}}

                        {{-- @error('book') <span class="text-red-500">{{ $message }}</span> @enderror --}}
                        <span class="sm:col-span-6">@livewire('transfer-school')</span>
                        {{-- <span class="sm:col-span-3">1. Type of the Transfer මාරුවීම් වර්ගය</span>
                        <x-form-list-input-section size="sm:col-span-3" name="type" id="type" :options="$transferTypes" label="" />

                        <span class="sm:col-span-3">2. Reason for the transfer ස්ථානමාරුව ඉල්ලුම් කිරීමට හේතු</span>
                        <x-form-list-input-section size="sm:col-span-3" name="reason" id="reason" :options="$transferReasons" label="" />

                        <div class="col-span-6">
                            <span class="sm:col-span-6">3. Expected Schools to be Transferred ස්ථාන මාරුවීම් අපේක්ෂිත පාසල් :</span>
                            <span class="sm:col-span-6">School 1</span>
                            <x-form-list-input-section size="sm:col-span-3" name="zoneSchool1" id="zoneSchool1" :options="$zoneSchools" label="" />
                            <span class="sm:col-span-6">School 2</span>
                            <x-form-list-input-section size="sm:col-span-3" name="zoneSchool2" id="zoneSchool2" :options="$zoneSchools" label="" />
                            <span class="sm:col-span-6">School 3</span>
                            <x-form-list-input-section size="sm:col-span-3" name="zoneSchool3" id="zoneSchool3" :options="$zoneSchools" label="" />
                            <span class="sm:col-span-6">School 4</span>
                            <x-form-list-input-section size="sm:col-span-3" name="zoneSchool4" id="zoneSchool4" :options="$zoneSchools" label="" />
                            <span class="sm:col-span-6">School 5</span>
                            <x-form-list-input-section size="sm:col-span-3" name="zoneSchool5" id="zoneSchool5" :options="$zoneSchools" label="" />
                        </div> --}}

                        <x-form-list-input-section size="sm:col-span-6" name="alternativeSchool" id="alternativeSchool" :options="$binaryList" label="4. If there aren’t vacancies in the requested zone, do you like to be transferred to any school in the requested zone අපේක්ෂිත පාසල්වල පුරප්පාඩු නොමැති නම් ඉල්ලා ඇති කලාපයේ වෙනත් ඕනෑම පාසලකට ස්ථානමාරුව ලබා ගැනීමට කැමතිද" />

                        <x-form-list-input-section size="sm:col-span-6" name="teachingGrades" id="teachingGrades" :options="$teachingGradeList" label="5. Current teaching grades (Only for teachers who teach in primary grades) දැනට පාසලේ ඉගැන්වීම් කරනු ලබන ශ්‍රේණි (ප්‍රාථමික ශ්‍රේණිවල උගන්වන ගුරුවරුන් සඳහා පමණි)" />


                        <x-form-text-input-section size="sm:col-span-6" name="extraCurricular" id="extraCurricular" label="6. Other extra-curricular activities entrusted in the present school දැනට පාසලේ භාරව ඇති බාහිර/වෙනත් කාර්යයන් " value="{{ old('extraCurricular') }}" />

                        <x-form-text-input-section size="sm:col-span-6" name="mention" id="mention" label="7. If you have anything else to mention, please mention it in this column ඔබට සඳහන් කිරීමට වෙනත් යමක් ඇත්නම්, කරුණාකර එය මෙම තීරුවේ සඳහන් කරන්න" value="{{ old('mention') }}" />

                        <div class="bg-gray-200 col-span-6 p-4">
                            <span class="sm:col-span-6">If current school service period is more than 5 years,  expected schools to be transfer within the zone වත්මන් පාසල් සේවා කාලය අවුරුදු 5 කට වඩා වැඩි නම්, කලාපය තුළ අපේක්ෂිත පාසල්</span></br>
                            <span class="sm:col-span-6">School 1</span>
                            <x-form-list-input-section size="sm:col-span-3" name="alterSchool1" id="alterSchool1" :options="$zoneSchools" label="" />
                            <span class="sm:col-span-6">School 2</span>
                            <x-form-list-input-section size="sm:col-span-3" name="alterSchool2" id="alterSchool2" :options="$zoneSchools" label="" />
                            <span class="sm:col-span-6">School 3</span>
                            <x-form-list-input-section size="sm:col-span-3" name="alterSchool3" id="alterSchool3" :options="$zoneSchools" label="" />
                            <span class="sm:col-span-6">School 4</span>
                            <x-form-list-input-section size="sm:col-span-3" name="alterSchool4" id="alterSchool4" :options="$zoneSchools" label="" />
                            <span class="sm:col-span-6">School 5</span>
                            <x-form-list-input-section size="sm:col-span-3" name="alterSchool5" id="alterSchool5" :options="$zoneSchools" label="" />
                        </div>

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

