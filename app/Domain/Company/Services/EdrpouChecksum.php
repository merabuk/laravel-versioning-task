<?php

declare(strict_types=1);

namespace App\Domain\Company\Services;

class EdrpouChecksum
{
    private const array WEIGHTS_DEFAULT   = [1, 2, 3, 4, 5, 6, 7];
    private const array WEIGHTS_ALTERNATE = [7, 1, 2, 3, 4, 5, 6];

    public static function weightsFor(int $value): array
    {
        return ($value < 30_000_000 || $value > 60_000_000)
            ? self::WEIGHTS_DEFAULT
            : self::WEIGHTS_ALTERNATE;
    }

    /**
     * @param int[] $digits
     * @param int[] $weights
     */
    public static function calculate(array $digits, array $weights): int
    {
        $sum = array_sum(array_map(fn (int $d, int $w) => $d * $w, $digits, $weights));
        $remainder = $sum % 11;

        if ($remainder < 10) {
            return $remainder;
        }

        $secondary = array_map(fn (int $w) => $w + 2, $weights);
        $sum = array_sum(array_map(fn (int $d, int $w) => $d * $w, $digits, $secondary));
        $remainder = $sum % 11;

        return $remainder >= 10 ? 0 : $remainder;
    }
}
