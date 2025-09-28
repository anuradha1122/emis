<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreteacherTransferRequest extends FormRequest
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
            'type'     => 'required|integer|gt:0',
            'reason'   => 'required|integer|gt:0',
            'school1'  => 'required|integer|gt:0',
            'school2'  => 'nullable|integer',
            'school3'  => 'nullable|integer',
            'school4'  => 'nullable|integer',
            'school5'  => 'nullable|integer',
            'alternativeSchool' => 'required|integer|gt:0',
            'teachingGrades'  => 'nullable|integer',
            'extraCurricular'  => 'nullable',
            'mention' => 'nullable',
            'alterSchool1'  => 'nullable|integer',
            'alterSchool2'  => 'nullable|integer',
            'alterSchool3'  => 'nullable|integer',
            'alterSchool4'  => 'nullable|integer',
            'alterSchool5'  => 'nullable|integer',

            // 'grade8' => 'required|integer|min:0|max:25',
            // 'grade9' => 'required|integer|min:0|max:25',
            // 'grade10' => 'required|integer|min:0|max:25',
            // 'grade11' => 'required|integer|min:0|max:25',
            // 'grade12art' => 'required|integer|min:0|max:25',
            // 'grade12commerce' => 'required|integer|min:0|max:25',
            // 'grade12science' => 'required|integer|min:0|max:25',
            // 'grade12technology' => 'required|integer|min:0|max:25',
            // 'grade1213years' => 'required|integer|min:0|max:25',
            // 'grade13art' => 'required|integer|min:0|max:25',
            // 'grade13commerce' => 'required|integer|min:0|max:25',
            // 'grade13science' => 'required|integer|min:0|max:25',
            // 'grade13technology' => 'required|integer|min:0|max:25',
            // 'grade1313years' => 'required|integer|min:0|max:25',
            // 'specialedu' => 'required|integer|min:0|max:25',
        ];
    }
}
