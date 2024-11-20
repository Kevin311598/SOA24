<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
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
            "name" => ["required", 'max:100', 'unique:events,name'],
            "titulo" => ["required", 'string'],
            "sub_titulo" => ["required", 'string'],
            "imagen_url" => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    public function attributes()
    {
        return [
            "imagen_url" => "Imagen",
            "name" => "Nombre",
        ];
    }
}
