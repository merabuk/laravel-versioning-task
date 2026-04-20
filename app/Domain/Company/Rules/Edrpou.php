<?php

namespace App\Domain\Company\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Domain\Company\Services\EdrpouValidator;

class Edrpou implements ValidationRule
{
    public function __construct(
        private EdrpouValidator $validator,
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match($this->validator::REGEX, $value)) {
            $fail(__('validation.custom.edrpou.regex'));

            return;
        }

        if (!$this->validator->validate($value)) {
            $fail(__('validation.custom.edrpou.check_digit'));
        }
    }
}
