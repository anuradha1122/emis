<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePrincipalTransferRequest extends FormRequest
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
            'appointmentLetterNo' => 'required|string',
            'serviceConfirm'      => 'required|integer|gt:0',
            'schoolDistance'      => 'required|numeric|lt:600',
            'position'            => 'nullable|numeric|gt:0',
            'specialChildren'     => 'required|integer|gt:0',
            'expectTransfer'      => 'required|integer|gt:0',
            'reason'              => 'nullable|string',
            'school1'             => 'nullable|integer',
            'distance1'           => 'nullable|numeric|lt:600',
            'school2'             => 'nullable|integer',
            'distance2'           => 'nullable|numeric|lt:600',
            'school3'             => 'nullable|integer',
            'distance3'           => 'nullable|numeric|lt:600',
            'school4'             => 'nullable|integer',
            'distance4'           => 'nullable|numeric|lt:600',
            'school5'             => 'nullable|integer',
            'distance5'           => 'nullable|numeric|lt:600',
            'otherSchool'         => 'required|integer|gt:0',
            'mention'             => 'nullable|string',
        ];
    }
}
