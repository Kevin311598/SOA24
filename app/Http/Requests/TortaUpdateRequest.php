<?php

namespace App\Http\Requests;

use App\Rules\ImagenUrl;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TortaUpdateRequest extends FormRequest
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
        $id = $this->route('id');
        return [
            "nombre" => ["required", 'max:100', Rule::unique('tortas', 'nombre')->ignore($id)],
            "precio" => ['required', 'decimal:0,2'],
            "imagen_url" => ['required', new ImagenUrl()],
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
