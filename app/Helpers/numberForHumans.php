<?php

namespace App\Helpers;

class numberForHumans
{
    // Divisor map for numbers
    private static $divisorMap = [
        1000 ** 0 => '',
        1000 ** 1 => 'K',
        1000 ** 2 => 'M',
        1000 ** 3 => 'B',
        1000 ** 4 => 'T',
        1000 ** 5 => 'Qa',
        1000 ** 6 => 'Qi',
    ];

    public static function divisorMap(array $divisorMap): void
    {
        self::$divisorMap = $divisorMap;
    }

    public static function numberForHumans($number, int $precision = 1, int $mode = PHP_ROUND_HALF_UP, ?array $divisorMap = []): string
    {
        $divisorMap = $divisorMap ?: self::$divisorMap;
        $divisors = array_filter(
            array_keys($divisorMap),
            static function ($divisor) use ($number): bool {
                return $divisor <= abs($number);
            }
        );
        $divisor = end($divisors) ?: 1;
        $suffix = $divisorMap[$divisor] ?? '';
        if ($divisor === 1) {
            return $number.$suffix;
        }

        return number_format(round($number / $divisor, $precision, $mode), $precision).$suffix;
    }
}
