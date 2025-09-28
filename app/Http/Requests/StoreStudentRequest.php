<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
            'guardianRelationship'
        ];

        foreach ($dropdownZeroFields as $field) {
            if ($this->has($field) && $this->input($field) == '0') {
                $this->merge([$field => null]);
            }
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'identificationNo' => ['required', 'string', 'max:255'],
            'registerNo' => ['nullable', 'integer', 'between:1,999'],

            'addressLine1' => ['required', 'string', 'max:255'],
            'addressLine2' => ['required', 'string', 'max:255'],
            'addressLine3' => ['nullable', 'string', 'max:255'],

            'nic' => ['nullable', 'regex:/^\d{9}[vVxX]$/', 'size:12', 'unique:students,nic'],
            'email' => ['nullable', 'email', 'max:255', 'unique:students,email'],
            'mobile' => ['nullable', 'digits:10'],

            'gender' => ['required', 'not_in:0'],
            'race' => ['required', 'exists:races,id', 'not_in:0'],
            'religion' => ['required', 'exists:religions,id', 'not_in:0'],
            'bloodGroup' => ['nullable'],
            'birthDay' => ['required', 'date', 'before:today'],
            'birthCertificate' => ['nullable', 'integer', 'between:1,999999'],

            'registerDate' => ['required', 'date'],

            // Guardian Info
            'guardianName' => ['nullable', 'string', 'max:255'],
            'guardianNic' => ['nullable', 'regex:/^(\d{9}[vVxX]|\d{12})$/'],
            'guardianRelationship' => ['nullable', 'not_in:0'],
            'guardianEmail' => ['nullable', 'email', 'max:255'],
            'guardianMobile' => ['nullable', 'digits:10'],

            // Optional location info
            'division' => ['nullable'],
            'gnDivision' => ['nullable'],
            'class' => ['required', 'not_in:0'],

            // Photo
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],

            // Mother Info
            'motherName' => ['nullable', 'string', 'max:255'],
            'motherNic' => ['nullable', 'regex:/^(\d{9}[vVxX]|\d{12})$/'],
            'motherEmail' => ['nullable', 'email', 'max:255'],
            'motherMobile' => ['nullable', 'digits:10'],

            // Father Info
            'fatherName' => ['nullable', 'string', 'max:255'],
            'fatherNic' => ['nullable', 'regex:/^(\d{9}[vVxX]|\d{12})$/'],
            'fatherEmail' => ['nullable', 'email', 'max:255'],
            'fatherMobile' => ['nullable', 'digits:10'],
        ];
    }

}
