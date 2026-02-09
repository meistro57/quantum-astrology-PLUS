<?php

declare(strict_types=1);

namespace App\Modules\Astrology\Services;

use Carbon\CarbonImmutable;

final class DeterministicEphemeris implements AstrologyEphemeris
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

    public function planetLongitudes(CarbonImmutable $dateTime, array $planets): array
    {
        $longitudes = [];

        foreach (self::PLANET_RATES as $planet => $rateData) {
            if ($planets !== [] && !in_array($planet, $planets, true)) {
                continue;
            }

            $longitudes[$planet] = $this->pseudoLongitude(
                $dateTime,
                $rateData['seed'],
                $rateData['rate']
            );
        }

        return $longitudes;
    }

    public function ascendantLongitude(
        CarbonImmutable $dateTime,
        float $latitude,
        float $longitude,
        string $houseSystem
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
}
