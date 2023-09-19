<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IntOrNull implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(
        string  $attribute,
        mixed   $value,
        Closure $fail
    ): void {
        if (!is_int($value) && !is_null($value)) {
            $fail('The :attribute must be a int or a null.');
        }
    }
}
