<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeacherRequest extends FormRequest
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

            'name' => ['required', 'string', 'max:100'],
            'addressLine1' => ['required', 'string', 'max:100'],
            'addressLine2' => ['required', 'string', 'max:100'],
            'addressLine3' => ['required', 'string', 'max:100'],
            'mobile' => ['required', 'string', 'max:10', 'unique:contact_infos,mobile1','unique:contact_infos,mobile2', 'regex:/^[0-9]{10,15}$/'],
            'nic' => ['required', 'unique:users,nic', 'regex:/^([0-9]{9}[VvXx]|[0-9]{12})$/'],
            'birthDay' => ['required', 'date', 'before:today'],
            'serviceDate' => ['required', 'date', 'after_or_equal:birthDay'],
            'category' => ['required', 'exists:appointment_categories,id'],
            'subject' => ['required', 'exists:subjects,id'],
            'ranks' => ['required', 'exists:ranks,id'],
            'medium' => ['required', 'exists:appointment_media,id'],
            'school' => ['required', 'exists:schools,id'],
            //'photo' => 'nullable|image|max:2048',

        ];
    }
}
