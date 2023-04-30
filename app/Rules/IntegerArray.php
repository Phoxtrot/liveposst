<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IntegerArray implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $integerOnly = collect($value)->every(fn ($integer)=> is_int($integer));
        if (!$integerOnly) {
            $fail($attribute." must be an integer");
        }
    }
}
