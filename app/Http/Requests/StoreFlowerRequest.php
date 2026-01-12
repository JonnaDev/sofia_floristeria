<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFlowerRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:1000',
            'stock' => 'required|integer|min:0',
            'photo_flower_url' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'exists:categories,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre de la flor es obligatorio.',
            'name.string' => 'El nombre debe ser texto válido.',
            'name.max' => 'El nombre no puede exceder 255 caracteres.',

            'price.required' => 'El precio es obligatorio.',
            'price.numeric' => 'El precio debe ser un número válido.',
            'price.min' => 'El precio debe ser mayor a $0.00.',

            'description.string' => 'La descripción debe ser texto válido.',
            'description.max' => 'La descripción no puede exceder 1000 caracteres.',

            'stock.required' => 'El stock es obligatorio.',
            'stock.integer' => 'El stock debe ser un número entero.',
            'stock.min' => 'El stock no puede ser negativo.',

            'photo_flower_url.required' => 'La imagen de la flor es obligatoria.',
            'photo_flower_url.image' => 'El archivo debe ser una imagen válida.',
            'photo_flower_url.mimes' => 'La imagen debe ser de tipo: jpeg, jpg, png o webp.',
            'photo_flower_url.max' => 'La imagen no puede ser mayor a 2MB.',

            'category_ids.required' => 'Debe seleccionar al menos una categoría.',
            'category_ids.array' => 'Las categorías deben ser un arreglo válido.',
            'category_ids.min' => 'Debe seleccionar al menos una categoría.',
            'category_ids.*.exists' => 'Una o más categorías seleccionadas no existen.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nombre de la flor',
            'price' => 'precio',
            'description' => 'descripción',
            'stock' => 'stock',
            'photo_flower_url' => 'imagen de la flor',
            'category_ids' => 'categorías',
        ];
    }
}
