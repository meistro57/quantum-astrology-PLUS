<?php

declare(strict_types=1);

namespace App\Modules\Numerology\Support;

final class NumberReducer
{
    /**
     * @var array<int>
     */
    private const MASTER_NUMBERS = [11, 22, 33];

    public function reduce(int $number): int
    {
        while ($number > 9 && !$this->isMasterNumber($number)) {
            $number = array_sum(str_split((string)$number));
        }

        return $number;
    }

    public function isMasterNumber(int $number): bool
    {
        return in_array($number, self::MASTER_NUMBERS, true);
    }
}
