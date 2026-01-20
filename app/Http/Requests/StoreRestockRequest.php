<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRestockRequest extends FormRequest
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
            'added_quantity' => 'required|integer|min:1|max:1000',
            'notes' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'added_quantity.required' => 'La cantidad a agregar es obligatoria.',
            'added_quantity.integer' => 'La cantidad debe ser un número entero.',
            'added_quantity.min' => 'La cantidad mínima es 1.',
            'added_quantity.max' => 'La cantidad máxima es 1000.',
            'notes.max' => 'Las notas no pueden exceder 500 caracteres.',
        ];
    }
}
