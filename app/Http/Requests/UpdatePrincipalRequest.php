<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePrincipalRequest extends FormRequest
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
        $section = $this->input('section');
        $teacherId = $this->input('id');
        //dd($section, $teacherId);
        $rules = [];

        if ($section === 'personal') {
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'nullable|email|max:255',
                'nic' => [
                    'required',
                    'string',
                    'regex:/^\d{9}[vVxX]$|^\d{12}$/',
                    Rule::unique('users', 'nic')->ignore($teacherId),
                ],
                'birthDay' => 'nullable|date',
                'perm_address1' => 'nullable|string|max:255',
                'perm_address2' => 'nullable|string|max:255',
                'perm_address3' => 'nullable|string|max:255',
                'res_address1' => 'nullable|string|max:255',
                'res_address2' => 'nullable|string|max:255',
                'res_address3' => 'nullable|string|max:255',
                'mobile1' => 'nullable|string|max:20',
                'mobile2' => 'nullable|string|max:20',
            ];
        }

        if ($section === 'personal-info') {
            //dd('here');
            $rules = [
                'race' => 'required|exists:races,id',
                'religion' => 'required|exists:religions,id',
                'civilStatus' => 'required|exists:civil_statuses,id',
                'genders' => 'required|string',
            ];
        }

        return $rules;
    }
}
