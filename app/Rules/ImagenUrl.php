<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

class ImagenUrl implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value instanceof UploadedFile) {
            if (!$value->isValid() || !in_array($value->getMimeType(), ['image/jpeg', 'image/png', 'image/jpg'])) {
                $fail('El campo :attribute debe ser una imagen válida (JPG, JPEG, PNG).');
            } elseif ($value->getSize() > 2048000) {
                $fail('El campo :attribute no puede ser mayor a 2MB.');
            }
        } elseif (is_string($value)) {
            $url = env('STORAGE_URL') . '/' . $value;

            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                $fail('El campo :attribute debe ser una URL válida.');
            }
            /*
             if (!$this->imageExists($url)) {
                 $fail('La imagen en la URL :attribute no existe o no es accesible.');
             }*/
        } else {
            $fail('El campo :attribute debe ser una URL válida o una imagen válida.');
        }
    }
}
