<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFlowerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:1000',
            'stock' => 'required|integer|min:0',
            'photo_flower_url' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048', // Opcional en update
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la flor es obligatorio.',
            'price.required' => 'El precio es obligatorio.',
            'stock.required' => 'El stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'photo_flower_url.image' => 'El archivo debe ser una imagen válida.',
            'photo_flower_url.mimes' => 'La imagen debe ser de tipo: jpeg, jpg, png o webp.',
            'category_ids.required' => 'Debe seleccionar al menos una categoría.',
            'category_ids.min' => 'Debe seleccionar al menos una categoría.',
        ];
    }
}
