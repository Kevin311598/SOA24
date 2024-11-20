<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TortaStoreRequest extends FormRequest
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
            "nombre" => ["required", 'max:100', 'unique:tortas,nombre'],
            "precio" => ['required', 'decimal:0,2'],
            "imagen_url" => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    public function attributes()
    {
        return [
            "imagen_url" => "Imagen",
            "nombre" => "Nombre",
            "precio" => "Precio",
        ];
    }
}
