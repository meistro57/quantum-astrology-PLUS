<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Enums\Planet;
use App\Enums\ZodiacSign;
use App\Modules\Astrology\Services\AstrologyCalculator;
use Carbon\CarbonImmutable;
use PHPUnit\Framework\TestCase;

final class AstrologyCalculatorTest extends TestCase
{
    private AstrologyCalculator $calculator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->calculator = new AstrologyCalculator();
    }

    public function testCalculateNatalChartUsesDeterministicVectors(): void
    {
        $dateTime = CarbonImmutable::create(1990, 6, 15, 12, 0, 0, 'UTC');

        $chart = $this->calculator->calculateNatalChart(
            $dateTime,
            40.7128,
            -74.0060
        );

        $this->assertSame(ZodiacSign::Gemini, $chart->sunSign);
        $this->assertEqualsWithDelta(83.7359135, $chart->sunLongitude, 0.0001);

        $this->assertSame(ZodiacSign::Capricorn, $chart->ascendantSign);
        $this->assertEqualsWithDelta(285.994, $chart->ascendantLongitude, 0.0001);

        $this->assertEqualsWithDelta(12.298439, $chart->planetLongitudes[Planet::Moon->value], 0.0001);
        $this->assertEqualsWithDelta(
            $chart->sunLongitude,
            $chart->planetLongitudes[Planet::Sun->value],
            0.0001
        );
    }

    public function testPlanetLongitudesIncludeCorePlanets(): void
    {
        $dateTime = CarbonImmutable::create(2001, 1, 1, 0, 0, 0, 'UTC');
        $chart = $this->calculator->calculateNatalChart($dateTime, 0.0, 0.0);

        $expectedPlanets = [
            Planet::Sun,
            Planet::Moon,
            Planet::Mercury,
            Planet::Venus,
            Planet::Mars,
            Planet::Jupiter,
            Planet::Saturn,
            Planet::Uranus,
            Planet::Neptune,
            Planet::Pluto,
        ];

        foreach ($expectedPlanets as $planet) {
            $this->assertArrayHasKey($planet->value, $chart->planetLongitudes);
            $this->assertGreaterThanOrEqual(0.0, $chart->planetLongitudes[$planet->value]);
            $this->assertLessThan(360.0, $chart->planetLongitudes[$planet->value]);
        }
    }
}
