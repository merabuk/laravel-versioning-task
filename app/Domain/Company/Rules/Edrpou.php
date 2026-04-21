<?php

declare(strict_types=1);

namespace App\Domain\Company\Rules;

use App\Domain\Company\Services\EdrpouValidator;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Edrpou implements ValidationRule
{
    public function __construct(
        private EdrpouValidator $validator,
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! preg_match($this->validator::REGEX, $value)) {
            $fail(__('validation.custom.edrpou.regex'));

            return;
        }

        if (! $this->validator->validate($value)) {
            $fail(__('validation.custom.edrpou.check_digit'));
        }
    }
}
