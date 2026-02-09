<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Modules\Astrology\Services\AstrologyEphemeris;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use RuntimeException;

final class AstrologyEphemerisHealthCommand extends Command
{
    /**
     * @var string
     */
    protected $signature = 'astrology:ephemeris-health {--datetime= : ISO-8601 datetime} {--lat=0 : Latitude} {--lon=0 : Longitude}';

    /**
     * @var string
     */
    protected $description = 'Validate Swiss Ephemeris availability and parsing output.';

    public function handle(AstrologyEphemeris $ephemeris): int
    {
        $dateTime = $this->resolveDateTime();
        $latitude = (float) $this->option('lat');
        $longitude = (float) $this->option('lon');
        $driver = (string) config('astrology.ephemeris_driver', 'swetest');

        $planets = (array) config('astrology.planets', []);

        try {
            $planetLongitudes = $ephemeris->planetLongitudes($dateTime, $planets);
            $ascendant = $ephemeris->ascendantLongitude(
                $dateTime,
                $latitude,
                $longitude,
                (string) config('astrology.defaults.house_system', 'placidus')
            );
        } catch (RuntimeException $exception) {
            $this->error($exception->getMessage());
            return self::FAILURE;
        }

        $this->info('Swiss Ephemeris OK.');
        $this->line('Driver: ' . $driver);
        $this->line('DateTime: ' . $dateTime->toIso8601String());
        $this->line('Ascendant: ' . number_format($ascendant, 6));
        $this->line('Planets:');

        foreach ($planetLongitudes as $planet => $longitudeValue) {
            $this->line(' - ' . $planet . ': ' . number_format($longitudeValue, 6));
        }

        return self::SUCCESS;
    }

    private function resolveDateTime(): CarbonImmutable
    {
        $input = (string) $this->option('datetime');
        if ($input === '') {
            return CarbonImmutable::now('UTC');
        }

        return CarbonImmutable::parse($input);
    }
}
