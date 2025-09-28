<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePrincipalTransferRequest extends FormRequest
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
            'decision1' => ['sometimes', 'required', 'integer', 'in:1,2'],
            'decision2' => ['sometimes', 'required', 'integer', 'in:1,2'],
            'decision3' => ['sometimes', 'required', 'integer', 'in:1,2'],
            'decision4' => ['sometimes', 'required', 'integer', 'in:1,2,3'],
        ];
    }
}
