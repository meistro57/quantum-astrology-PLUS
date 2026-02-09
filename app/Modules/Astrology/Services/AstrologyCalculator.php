<?php

declare(strict_types=1);

namespace App\Modules\Astrology\Services;

use App\Enums\Planet;
use App\Enums\ZodiacSign;
use App\Modules\Astrology\DTOs\NatalChartData;
use Carbon\CarbonImmutable;

final class AstrologyCalculator
{
    /**
     * Deterministic placeholder rates (degrees/day) for stable test vectors.
     * Not a replacement for Swiss Ephemeris accuracy.
     *
     * @var array<string, array{seed: float, rate: float}>
     */
    private const PLANET_RATES = [
        'sun' => ['seed' => 280.460, 'rate' => 0.985647],
        'moon' => ['seed' => 218.316, 'rate' => 13.176358],
        'mercury' => ['seed' => 60.000, 'rate' => 4.092385],
        'venus' => ['seed' => 50.000, 'rate' => 1.602130],
        'mars' => ['seed' => 19.000, 'rate' => 0.524039],
        'jupiter' => ['seed' => 34.000, 'rate' => 0.083056],
        'saturn' => ['seed' => 50.000, 'rate' => 0.033459],
        'uranus' => ['seed' => 314.000, 'rate' => 0.011728],
        'neptune' => ['seed' => 304.000, 'rate' => 0.005981],
        'pluto' => ['seed' => 238.000, 'rate' => 0.003960],
    ];

    public function calculateNatalChart(
        CarbonImmutable $dateTime,
        float $latitude,
        float $longitude
    ): NatalChartData {
        $planetLongitudes = $this->calculatePlanetLongitudes($dateTime);

        $sunLongitude = $planetLongitudes[Planet::Sun->value];
        $sunSign = ZodiacSign::fromLongitude($sunLongitude);

        $ascendantLongitude = $this->calculateAscendantLongitude($dateTime, $longitude);
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

    /**
     * @return array<string, float>
     */
    private function calculatePlanetLongitudes(CarbonImmutable $dateTime): array
    {
        $longitudes = [];

        foreach (self::PLANET_RATES as $planet => $rateData) {
            $longitudes[$planet] = $this->pseudoLongitude(
                $dateTime,
                $rateData['seed'],
                $rateData['rate']
            );
        }

        return $longitudes;
    }

    private function pseudoLongitude(
        CarbonImmutable $dateTime,
        float $seedDegrees,
        float $dailyRate
    ): float {
        $days = $dateTime->timestamp / 86400;
        $longitude = fmod($seedDegrees + ($days * $dailyRate), 360.0);

        if ($longitude < 0) {
            $longitude += 360.0;
        }

        return $longitude;
    }

    private function calculateAscendantLongitude(
        CarbonImmutable $dateTime,
        float $longitude
    ): float {
        $hour = (int) $dateTime->format('G');
        $minute = (int) $dateTime->format('i');
        $minuteDegrees = $minute * 0.25;

        $ascendant = fmod($longitude + 180.0 + ($hour * 15.0) + $minuteDegrees, 360.0);
        if ($ascendant < 0) {
            $ascendant += 360.0;
        }

        return $ascendant;
    }
}
