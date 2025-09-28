<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentContactInfoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255', // Full Name
            'identificationNo' => 'required|string|max:255',
            'registerNo' => 'nullable|integer|between:1,999',
            'addressLine1' => 'required|string|max:255', // Address Line 1
            'addressLine2' => 'required|string|max:255', // Address Line 2
            'addressLine3' => 'nullable|string|max:255', // Address Line 3 (optional)
            'nic' => 'nullable|regex:/^\d{9}[vVxX]$/|size:10|unique:students,nic', // NIC (optional)
            'email' => 'nullable|email|max:255|unique:students,email', // Email (optional)
            'mobile' => 'nullable|digits:10', // Mobile
            'gender' => 'required|not_in:0', // Gender
            'race' => 'required|exists:races,id|not_in:0', // Race
            'religion' => 'required|exists:religions,id|not_in:0', // Religion
            'bloodGroup' => 'nullable', // Blood Group
            'birthDay' => 'required|date|before:today', // Birth Day
            'birthCertificate' => 'required|integer|between:1,999999', // Birth Certificate
            // 'birthProvince' => 'required|exists:provinces,id|not_in:0', // Birth Province
            // 'birthDistrict' => 'required|exists:districts,id|not_in:0',
            // 'birthDsDivision' => 'required|not_in:0',
            'registerDate' => 'required|date', // Registered Date
            'guardianName' => 'nullable|string|max:255', // Guardian Full Name
            'guardianNic' => 'nullable|regex:/^\d{9}[vVxX]$/|size:10', // guardian NIC
            'guardianRelationship' => 'nullable|not_in:0', // Guardian Relationship
            'guardianEmail' => 'nullable|email|max:255', // Guardian Email (optional)
            'guardianMobile' => 'nullable|digits:10', // Guardian Mobile
            'division' => 'nullable', // DS Division selection
            'gnDivision' => 'nullable', // GN Division selection
            'class' => 'required|not_in:0', // Division Name
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Photo (optional)
        ];
    }
}
