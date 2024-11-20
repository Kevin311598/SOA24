<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderStore extends FormRequest
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
            "event_id" => ["required"],
            "shipping_address" => ["required"],
            "event_date" => ["required"],
            "details" => ["required"],
            "total" => ["required"],
            "tortas" => ["required"]
        ];
    }

    public function attributes()
    {
        return [
            "event_id" => "Evento",
            "shipping_address" => "Direccion",
            "event_date" => "fecha",
            "details" => "detalles",
        ];
    }
}
