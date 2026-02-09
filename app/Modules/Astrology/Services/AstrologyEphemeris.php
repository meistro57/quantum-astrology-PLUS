<?php

declare(strict_types=1);

namespace App\Modules\Astrology\Services;

use Carbon\CarbonImmutable;

interface AstrologyEphemeris
{
    /**
     * @param array<string> $planets
     * @return array<string, float>
     */
    public function planetLongitudes(CarbonImmutable $dateTime, array $planets): array;

    public function ascendantLongitude(
        CarbonImmutable $dateTime,
        float $latitude,
        float $longitude,
        string $houseSystem
    ): float;
}
