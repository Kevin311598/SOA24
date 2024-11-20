<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
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
            "user_id" => ["required"],
            "event_id" => ["required"],
            "shipping_address" => ["required", "string", "max:100"],
            "event_date" => ["required"],
            "delivery_date" => ["nullable"],
            "status" => ["required"],
            "details" => ["nullable"],
            "tortas" => ["required"],
            "total" => ["required", "numeric"],
        ];
    }
}