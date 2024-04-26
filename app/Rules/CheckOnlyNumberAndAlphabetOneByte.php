<?php

namespace App\Rules;

use App\Libs\ConfigUtil;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckOnlyNumberAndAlphabetOneByte implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (mb_strlen($value) != strlen($value) || preg_match('/^[ -~]+$/', $value) == 0) {
            $fail(ConfigUtil::getMessage('EBT005', [':attribute']));
        }
    }
}
