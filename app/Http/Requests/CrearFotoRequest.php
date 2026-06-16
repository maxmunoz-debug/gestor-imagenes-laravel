<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearFotoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Cambiamos a true para permitir el uso
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'album_id' => 'required|exists:albums,album_id', // Debe existir en la tabla albums
            'nombre' => 'required',
            'descripcion' => 'required',
            'imagen' => 'required|image|max:20000', // Máximo ~20MB
        ];
    }
}