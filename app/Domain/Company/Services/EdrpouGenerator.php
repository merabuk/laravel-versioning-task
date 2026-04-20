<?php

declare(strict_types=1);

namespace App\Domain\Company\Services;

final class EdrpouGenerator
{
    public function generate(): string
    {
        $prefix = (string) random_int(1_000_000, 9_999_999);
        $digits = array_map(intval(...), mb_str_split($prefix));
        $weights = EdrpouChecksum::weightsFor((int) $prefix);
        $checkDigit = EdrpouChecksum::calculate($digits, $weights);

        return $prefix . $checkDigit;
    }
}
