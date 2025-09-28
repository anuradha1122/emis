<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $dropdownZeroFields = [
            'race', 'religion', 'civilStatus', 'division', 'gnDivision',
            'educationQualification', 'professionalQualification', 'userEduQualification', 'userProfQualification', 'school', 'familyInfo', 'familyMemberType', 'rank', 'userRank'
        ];

        foreach ($dropdownZeroFields as $field) {
            if ($this->has($field) && $this->input($field) == '0') {
                $this->merge([$field => null]);
            }
        }
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->input('category') === 'userQualification') {
                // Education pair rule
                $eduQual = $this->filled('educationQualification') && $this->input('educationQualification') != 0;
                $eduDate = $this->filled('eduEffectiveDay');

                if ($eduQual xor $eduDate) {
                    $validator->errors()->add('educationQualification', 'Education qualification and effective day must both be filled.');
                    $validator->errors()->add('eduEffectiveDay', 'Education qualification and effective day must both be filled.');
                }

                // Professional pair rule
                $profQual = $this->filled('professionalQualification') && $this->input('professionalQualification') != 0;
                $profDate = $this->filled('profEffectiveDay');

                if ($profQual xor $profDate) {
                    $validator->errors()->add('professionalQualification', 'Professional qualification and effective day must both be filled.');
                    $validator->errors()->add('profEffectiveDay', 'Professional qualification and effective day must both be filled.');
                }
            }
        });
    }




    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if(!$this->has('category')){
            $rules = [
                'name' => ['required', 'string', 'max:100'],
                'addressLine1' => ['required', 'string', 'max:100'],
                'addressLine2' => ['required', 'string', 'max:100'],
                'addressLine3' => ['required', 'string', 'max:100'],
                'mobile' => ['required', 'string', 'max:10', 'unique:contact_infos,mobile1','unique:contact_infos,mobile2', 'regex:/^[0-9]{10,15}$/'],

                //'school' => ['required', 'not_in:0'],
                'nic' => ['required', 'unique:users,nic', 'regex:/^([0-9]{9}[VvXx]|[0-9]{12})$/'],
                'birthDay' => ['required', 'date', 'before:today'],
                'serviceDate' => ['required', 'date', 'after_or_equal:birthDay'],
            ];

            // Conditionally add 'zone' validation rule
            if ($this->has('zone')) {
                $rules['zone'] = ['required', 'not_in:0'];
            }
            //dd($this->has('school'));
            if ($this->has('school')) {
                $rules['school'] = ['required', 'not_in:0'];
            }

            if($this->has('subject')){
                $rules['subject'] = ['required', 'exists:subjects,id'];
            }

            if($this->has('medium')){
                $rules['medium'] = ['required', 'exists:appointment_media,id'];
            }

            if($this->has('acategory')){
                $rules['acategory'] = ['required', 'exists:appointment_categories,id'];
            }

            if($this->has('rank')){
                $rules['rank'] = ['required', 'exists:ranks,id'];
            }


        }else {
            $rules['category'] = ['required']; // or omit this completely if it's always present
            //dd($this->input('currentPassword'));
            if ($this->input('category') === 'login') {
                $rules['currentPassword'] = ['required', 'string'];
                $rules['newPassword']     = ['required', 'string', 'min:6'];
                $rules['confirmPassword'] = ['required', 'same:newPassword'];
            }

            if ($this->input('category') === 'userLogin') {
                $rules['userId'] = ['required'];
            }

            if ($this->input('category') === 'userName') {
                $rules['name'] = ['required'];
            }

            if ($this->input('category') === 'userContact') {
                $rules['permAddressLine1'] = ['sometimes', 'nullable', 'string', 'max:100'];
                $rules['permAddressLine2'] = ['sometimes', 'nullable', 'string', 'max:100'];
                $rules['permAddressLine3'] = ['sometimes', 'nullable', 'string', 'max:100'];

                $rules['tempAddressLine1'] = ['sometimes', 'nullable', 'string', 'max:100'];
                $rules['tempAddressLine2'] = ['sometimes', 'nullable', 'string', 'max:100'];
                $rules['tempAddressLine3'] = ['sometimes', 'nullable', 'string', 'max:100'];

                $rules['mobile1'] = ['sometimes', 'nullable', 'regex:/^[0-9]{10}$/'];
                $rules['mobile2'] = ['sometimes', 'nullable', 'regex:/^[0-9]{10}$/'];

                $rules['email'] = ['sometimes', 'nullable', 'email', 'max:150'];
            }

            if ($this->input('category') === 'userPersonal') {
                $rules['race']        = ['sometimes', 'nullable'];
                $rules['religion']    = ['sometimes', 'nullable'];
                $rules['civilStatus'] = ['sometimes', 'nullable'];
                $rules['birthDay']    = ['sometimes', 'nullable', 'date', 'before:today'];
            }

            if ($this->input('category') === 'userLocation') {
                $rules['division']   = ['sometimes', 'nullable'];
                $rules['gnDivision'] = ['sometimes', 'nullable'];
            }

            if ($this->input('category') === 'userAppointment') {

                // ✅ New Appointment: validate only if all required fields exist
                if (
                    $this->filled('newAppointmentStartDay') &&
                    $this->filled('zoneSchool')
                ) {
                    $rules['newAppointmentStartDay'] = ['required', 'date'];
                    $rules['zoneSchool'] = ['required', 'integer'];
                }

                // ✅ Previous Appointment: validate only if all required fields exist
                if (
                    $this->filled('previousAppointmentStartDay') &&
                    $this->filled('previousAppointmentEndDay')
                ) {
                    $rules['previousAppointmentStartDay'] = ['required', 'date'];
                    $rules['previousAppointmentEndDay'] = ['required', 'date', 'after_or_equal:previousAppointmentStartDay'];
                }

                // ✅ Delete Appointment: validate only if field exists and not empty
                if ($this->filled('appointment_list')) {
                    $rules['appointment_list'] = ['required'];
                }

                // ✅ Terminate Appointment: validate only if all required fields exist
                if (
                    $this->filled('terminateReason') &&
                    $this->filled('terminateDate')
                ) {
                    $rules['terminateReason'] = ['required'];
                    $rules['terminateDate'] = ['required', 'date'];
                }
            }


            if ($this->input('category') === 'userQualification') {
                $rules['educationQualification']      = ['nullable', 'not_in:0', 'exists:education_qualifications,id'];
                $rules['eduEffectiveDay']             = ['nullable', 'date'];
                $rules['educationDescription']        = ['nullable', 'string'];

                $rules['professionalQualification']   = ['nullable', 'not_in:0', 'exists:professional_qualifications,id'];
                $rules['profEffectiveDay']            = ['nullable', 'date'];
                $rules['professionalDescription']     = ['nullable', 'string'];

                if ($this->filled('userEduQualification')) {
                    $rules['userEduQualification'] = ['exists:education_qualification_infos,id'];
                }

                if ($this->filled('userProfQualification')) {
                    $rules['userProfQualification'] = ['exists:professional_qualification_infos,id'];
                }
            }

            if ($this->input('category') === 'userFamily') {
                // Validation for adding a family member
                if ($this->filled('familyMemberType') || $this->filled('familyMemberName')) {
                    $rules['familyMemberType'] = ['required', 'exists:family_member_types,id'];
                    $rules['familyMemberName'] = ['required', 'string', 'max:100'];
                    $rules['familyMemberProfession'] = ['nullable', 'string', 'max:100'];

                    if ($this->filled('familyMemberNic')) {
                        $rules['familyMemberNic'] = ['regex:/^([0-9]{9}[vVxX]|[0-9]{12})$/'];
                    }

                    if ($this->filled('school')) {
                        $rules['school'] = ['exists:schools,id'];
                    }
                }

                // Validation for deleting a family member
                if ($this->filled('familyInfo')) {
                    $rules['familyInfo'] = ['exists:family_infos,id'];
                }
            }

            if ($this->input('category') === 'userRank') {
                if ($this->filled('rank') || $this->filled('rankedDate')) {
                    $rules['rank'] = ['required', 'exists:ranks,id'];
                    $rules['rankedDate'] = ['required', 'date', 'before_or_equal:today'];
                }

                if ($this->filled('userRank')) {
                    $rules['userRank'] = ['exists:user_service_in_ranks,id'];
                }
            }

        }



        //dd($this->input('school'));
        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The full name is required.',
            'name.string' => 'The full name must be a string.',
            'name.max' => 'The full name cannot exceed 100 characters.',

            'addressLine1.required' => 'Address Line 1 is required.',
            'addressLine1.string' => 'Address Line 1 must be a string.',
            'addressLine1.max' => 'Address Line 1 cannot exceed 100 characters.',

            'addressLine2.required' => 'Address Line 2 is required.',
            'addressLine2.string' => 'Address Line 2 must be a string.',
            'addressLine2.max' => 'Address Line 2 cannot exceed 100 characters.',

            'addressLine3.required' => 'Address Line 3 is required.',
            'addressLine3.string' => 'Address Line 3 must be a string.',
            'addressLine3.max' => 'Address Line 3 cannot exceed 100 characters.',

            'mobile.required' => 'The mobile number is required.',
            'mobile.string' => 'The mobile number must be a string.',
            'mobile.max' => 'The mobile number cannot exceed 10 characters.',
            'mobile.unique' => 'The mobile number has already been taken.',
            'mobile.regex' => 'The mobile number must be between 10 and 15 digits.',

            'subject.required' => 'The subject is required.',
            'subject.exists' => 'The selected subject is invalid.',

            'medium.required' => 'The appointment medium is required.',
            'medium.exists' => 'The selected medium is invalid.',

            'school.required' => 'The school is required.',
            'school.not_in' => 'Please select a valid school.',

            'zone.required' => 'The zone is required.',
            'zone.not_in' => 'Please select a valid zone.',

            'nic.required' => 'The NIC is required.',
            'nic.unique' => 'The NIC has already been taken.',
            'nic.regex' => 'The NIC format is invalid. It must be either 9 digits followed by V/v or 12 digits.',

            'birthDay.required' => 'The birth date is required.',
            'birthDay.date' => 'The birth date must be a valid date.',
            'birthDay.before' => 'The birth date must be before today.',

            'serviceDate.required' => 'The service appointed date is required.',
            'serviceDate.date' => 'The service appointed date must be a valid date.',
            'serviceDate.after_or_equal' => 'The service appointed date must be after or equal to the birth date.',
        ];
    }

}
