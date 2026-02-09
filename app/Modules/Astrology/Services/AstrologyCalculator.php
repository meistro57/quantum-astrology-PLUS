<?php

declare(strict_types=1);

namespace App\Modules\Astrology\Services;

use App\Enums\ZodiacSign;
use App\Modules\Astrology\DTOs\NatalChartData;
use Carbon\CarbonImmutable;

final class AstrologyCalculator
{
    public function __construct(
        private readonly AstrologyEphemeris $ephemeris
    ) {}

    public function calculateNatalChart(
        CarbonImmutable $dateTime,
        float $latitude,
        float $longitude
    ): NatalChartData {
        $planetLongitudes = $this->ephemeris->planetLongitudes(
            $dateTime,
            config('astrology.planets', [])
        );

        $sunLongitude = $planetLongitudes['sun'] ?? 0.0;
        $sunSign = ZodiacSign::fromLongitude($sunLongitude);

        $houseSystem = (string) config('astrology.defaults.house_system', 'placidus');
        $ascendantLongitude = $this->ephemeris->ascendantLongitude(
            $dateTime,
            $latitude,
            $longitude,
            $houseSystem
        );
        $ascendantSign = ZodiacSign::fromLongitude($ascendantLongitude);

        return new NatalChartData(
            dateTime: $dateTime,
            latitude: $latitude,
            longitude: $longitude,
            sunLongitude: $sunLongitude,
            sunSign: $sunSign,
            ascendantLongitude: $ascendantLongitude,
            ascendantSign: $ascendantSign,
            planetLongitudes: $planetLongitudes
        );
    }
}
