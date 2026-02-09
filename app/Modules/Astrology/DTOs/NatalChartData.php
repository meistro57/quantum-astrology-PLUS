<?php

declare(strict_types=1);

namespace App\Modules\Astrology\DTOs;

use App\Enums\ZodiacSign;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

final class NatalChartData extends Data
{
    /**
     * @param array<string, float> $planetLongitudes
     */
    public function __construct(
        public readonly CarbonImmutable $dateTime,
        public readonly float $latitude,
        public readonly float $longitude,
        public readonly float $sunLongitude,
        public readonly ZodiacSign $sunSign,
        public readonly float $ascendantLongitude,
        public readonly ZodiacSign $ascendantSign,
        public readonly array $planetLongitudes
    ) {}
}
