<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSchoolClassListRequest extends FormRequest
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
            'grade1' => 'required|integer|min:0|max:25',
            'grade2' => 'required|integer|min:0|max:25',
            'grade3' => 'required|integer|min:0|max:25',
            'grade4' => 'required|integer|min:0|max:25',
            'grade5' => 'required|integer|min:0|max:25',
            'grade6' => 'required|integer|min:0|max:25',
            'grade7' => 'required|integer|min:0|max:25',
            'grade8' => 'required|integer|min:0|max:25',
            'grade9' => 'required|integer|min:0|max:25',
            'grade10' => 'required|integer|min:0|max:25',
            'grade11' => 'required|integer|min:0|max:25',
            'grade12art' => 'required|integer|min:0|max:25',
            'grade12commerce' => 'required|integer|min:0|max:25',
            'grade12science' => 'required|integer|min:0|max:25',
            'grade12technology' => 'required|integer|min:0|max:25',
            'grade1213years' => 'required|integer|min:0|max:25',
            'grade13art' => 'required|integer|min:0|max:25',
            'grade13commerce' => 'required|integer|min:0|max:25',
            'grade13science' => 'required|integer|min:0|max:25',
            'grade13technology' => 'required|integer|min:0|max:25',
            'grade1313years' => 'required|integer|min:0|max:25',
            'specialedu' => 'required|integer|min:0|max:25',
        ];
    }
}
