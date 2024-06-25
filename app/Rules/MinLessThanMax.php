<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MinLessThanMax implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Obtener el valor de percentage_max del request
        $maxPercentage = request()->input('percentage_max');

        // Si percentage_max es nulo, no necesitamos comparar
        if (!is_null($maxPercentage) && $value >= $maxPercentage) {
            $fail('El porcentaje mínimo debe ser menor que el porcentaje máximo.');
        }
    }
}
