<x-app-layout>
    <div class="py-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-breadcrumb :list="$option" />
            <div class="isolate bg-white px-6 py-5 sm:py-5 lg:px-4">
                <x-form-heading heading="STUDENT REGISTRATION" subheading="Student Registration Form" />
                <x-form-success message="{{ session('success') }}" />
                <form method="POST" action="{{ route('student.register') }}" class="mx-auto mt-8 max-w-xl sm:mt-8" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 gap-x-3 gap-y-3 sm:grid-cols-6">
                        <h2 class="sm:col-span-6">Personal Detail</h2>
                        <hr class="sm:col-span-6">
                        <x-form-text-input-section size="sm:col-span-6" name="name" id="name" label="Full Name" value="{{ old('name') }}" />
                        <x-form-text-input-section size="sm:col-span-3" name="identificationNo" id="identificationNo" label="Student Identification No" value="{{ old('identificationNo') }}" />
                        <x-form-number-input-section size="sm:col-span-3" name="registerNo" id="registerNo" label=" Register No(Attendence Marking book)" value="{{ old('registerNo') }}" />
                        <x-form-text-input-section size="sm:col-span-2" name="addressLine1" id="addressLine1" label="Address Line 1" value="{{ old('addressLine1') }}" />
                        <x-form-text-input-section size="sm:col-span-2" name="addressLine2" id="addressLine2" label="Address Line 2" value="{{ old('addressLine2') }}" />
                        <x-form-text-input-section size="sm:col-span-2" name="addressLine3" id="addressLine3" label="Address Line 3" value="{{ old('addressLine3') }}" />
                        <span class="sm:col-span-2">@livewire('formStudentNic')</span>
                        <span class="sm:col-span-2">@livewire('formStudentEmail')</span>
                        <x-form-text-input-section size="sm:col-span-2" name="mobile" id="mobile" label="Mobile (optional)" value="{{ old('mobile') }}" />
                        <x-form-list-input-section size="sm:col-span-2" name="gender" id="gender" :options="$genders" label="Gender" />
                        <x-form-list-input-section size="sm:col-span-2" name="race" id="race" :options="$races" label="Race" />
                        <x-form-list-input-section size="sm:col-span-2" name="religion" id="religion" :options="$religions" label="Religion" />
                        <h2 class="sm:col-span-6">School Detail</h2>
                        <hr class="sm:col-span-6">
                        <x-form-list-input-section size="sm:col-span-3" name="class" id="class" :options="$classes" label="Class" />
                        <x-form-date-input-section size="sm:col-span-3" name="registerDate" id="registerDate" label="Registered Date" value="{{ old('registerDate') }}" />

                        <h2 class="sm:col-span-6">Birth Detail</h2>
                        <hr class="sm:col-span-6">

                        {{-- <x-form-text-input-section size="sm:col-span-2" name="nic" id="nic" label="NIC" /> --}}
                        <x-form-number-input-section size="sm:col-span-3" name="birthCertificate" id="birthCertificate" label="Birth Certificate No" value="{{ old('birthCertificate') }}" />
                        <x-form-date-input-section size="sm:col-span-3" name="birthDay" id="birthDay" label="Birth Day" value="{{ old('birthDay') }}" />
                        <span class="sm:col-span-6">@livewire('StudentBirthLocation')</span>

                        <h2 class="sm:col-span-6">Health Detail</h2>
                        <hr class="sm:col-span-6">
                        <x-form-list-input-section size="sm:col-span-3" name="illness" id="bloodGroup" :options="$bloodGroups" label="Blood Group (optional)" />
                        <x-form-list-input-section size="sm:col-span-3" name="illness" id="illness" :options="$illnesses" label="Illnesses (optional)" />

                        <h2 class="sm:col-span-6">Parents/Guardian Detail</h2>
                        <hr class="sm:col-span-6">
                        <x-form-text-input-section size="sm:col-span-6" name="motherName" id="motherName" label="Mother Full Name" value="{{ old('motherName') }}" />
                        <x-form-text-input-section size="sm:col-span-3" name="motherNic" id="motherNic" label="Mother NIC" value="{{ old('motherNic') }}" />
                        <x-form-text-input-section size="sm:col-span-3" name="motherEmail" id="motherEmail" label="Mother Email (optional)" value="{{ old('motherEmail') }}" />
                        <x-form-text-input-section size="sm:col-span-3" name="motherMobile" id="motherMobile" label="Mother Mobile" value="{{ old('motherMobile') }}" />
                        <x-form-text-input-section size="sm:col-span-6" name="fatherName" id="fatherName" label="Father Full Name" value="{{ old('fatherName') }}" />
                        <x-form-text-input-section size="sm:col-span-3" name="fatherNic" id="fatherNic" label="Father NIC" value="{{ old('fatherNic') }}" />
                        <x-form-text-input-section size="sm:col-span-3" name="fatherEmail" id="fatherEmail" label="Father Email (optional)" value="{{ old('fatherEmail') }}" />
                        <x-form-text-input-section size="sm:col-span-3" name="fatherMobile" id="fatherMobile" label="Father Mobile" value="{{ old('fatherMobile') }}" />
                        <x-form-text-input-section size="sm:col-span-6" name="guardianName" id="guardianName" label="Guardian Full Name" value="{{ old('guardianName') }}" />
                        <x-form-text-input-section size="sm:col-span-3" name="guardianNic" id="guardianNic" label="Guardian NIC" value="{{ old('guardianNic') }}" />
                        <x-form-list-input-section size="sm:col-span-3" name="guardianRelationship" id="guardianRelationship" :options="$guardianRelationships" label="Guardian Relationship" />
                        <x-form-text-input-section size="sm:col-span-3" name="GuardianEmail" id="guardianEmail" label="guardianEmail (optional)" value="{{ old('guardianEmail') }}" />
                        <x-form-text-input-section size="sm:col-span-3" name="guardianMobile" id="guardianMobile" label="Guardian Mobile" value="{{ old('guardianMobile') }}" />

                        <h2 class="sm:col-span-6">Profile Picture</h2>
                        <hr class="sm:col-span-6">
                        <span class="sm:col-span-4">@livewire('formStudentProfilePicture')</span>

                        <h2 class="sm:col-span-6">Location Detail</h2>
                        <hr class="sm:col-span-6">
                        <span class="sm:col-span-6">@livewire('formEducationDivision') </span>
                        <span class="sm:col-span-6">@livewire('formGnDivision')</span>
                    </div>
                    <div class="mt-10">
                        <x-form-button-primary size="" text="Register" modelBinding=""/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
