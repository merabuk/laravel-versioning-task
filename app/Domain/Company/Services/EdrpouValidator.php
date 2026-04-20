<?php

declare(strict_types=1);

namespace App\Domain\Company\Services;

final class EdrpouValidator
{
    public const string REGEX = '/^\d{8}$/';

    public function validate(string $edrpou): bool
    {
        if (!preg_match(self::REGEX, $edrpou)) {
            return false;
        }

        $digits = array_map(intval(...), mb_str_split($edrpou));
        $weights = EdrpouChecksum::weightsFor((int) $edrpou);
        $expected = EdrpouChecksum::calculate(array_slice($digits, 0, 7), $weights);

        return $expected === $digits[7];
    }
}
