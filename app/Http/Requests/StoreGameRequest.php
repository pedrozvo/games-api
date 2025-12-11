<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGameRequest extends FormRequest
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
            'title' => 'required|string|max:255|unique:games,title',
            'description' => 'required|string|max:1000',
            'genre' => 'required|string|max:100',
            'platform' => 'required|string|max:100',
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
            'title.required' => 'El título del juego es obligatorio',
            'title.unique' => 'Ya existe un juego con ese título',
            'title.max' => 'El título no puede exceder 255 caracteres',
            'description.required' => 'La descripción es obligatoria',
            'description.max' => 'La descripción no puede exceder 1000 caracteres',
            'genre.required' => 'El género es obligatorio',
            'genre.max' => 'El género no puede exceder 100 caracteres',
            'platform.required' => 'La plataforma es obligatoria',
            'platform.max' => 'La plataforma no puede exceder 100 caracteres',
        ];
    }
}
