<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeacherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'nic' => ['sometimes', 'required', 'unique:users,nic', 'regex:/^([0-9]{9}[VvXx]|[0-9]{12})$/'],
            'name' => ['sometimes','required', 'string', 'max:100'],
            'permAddressLine1' => ['sometimes', 'nullable', 'max:100'],
            'permAddressLine2' => ['sometimes', 'nullable', 'max:100'],
            'permAddressLine3' => ['sometimes', 'nullable', 'max:100'],
            'tempAddressLine1' => ['sometimes', 'nullable', 'max:100'],
            'tempAddressLine2' => ['sometimes', 'nullable', 'max:100'],
            'tempAddressLine3' => ['sometimes', 'nullable', 'max:100'],
            'mobile1' => ['sometimes','nullable','string','unique:contact_infos,mobile1','unique:contact_infos,mobile2','regex:/^[0-9]{10}$/'],
            'mobile2' => ['sometimes','nullable','string','unique:contact_infos,mobile1','unique:contact_infos,mobile2','regex:/^[0-9]{10}$/'],
            'email' => ['sometimes', 'nullable', 'email', 'unique:users,email', 'max:100'],
            'race' => ['sometimes', 'nullable', 'not_in:0'],
            'religion' => ['sometimes', 'nullable', 'not_in:0'],
            'civilStatus' => ['sometimes', 'nullable', 'not_in:0'],
            'birthDay' => ['sometimes', 'nullable', 'date', 'before:today'],
            'rank' => ['nullable'],
            'rankedDay' => ['nullable', 'date', 'before:today'],
            'newAppointmentStartDay' => ['sometimes', 'nullable', 'date'],
        ];
    }
}
