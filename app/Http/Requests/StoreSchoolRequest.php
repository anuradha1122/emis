<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSchoolRequest extends FormRequest
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
            'name'          => 'required|string|max:255',
            'addressLine1'  => 'required|string|max:255',
            'addressLine2'  => 'nullable|string|max:255',
            'addressLine3'  => 'nullable|string|max:255',
            'mobile'        => 'required|digits_between:9,10',
            'census'        => 'required|string|max:6',
            'division'      => 'required|exists:offices,id',
            'authorities'   => 'required|exists:school_authorities,id',
            'ethnicity'     => 'required|exists:school_ethnicities,id',
            'class'         => 'required|exists:school_classes,id',
            'density'       => 'required|exists:school_densities,id',
            'facility'      => 'required|exists:school_facilities,id',
            'gender'        => 'required|exists:school_genders,id',
            'language'      => 'required|exists:school_languages,id',
            'religion'      => 'required|exists:school_religions,id',
        ];
    }
}
