<?php

declare(strict_types=1);

namespace App\Modules\Astrology\Services;

use App\Enums\Planet;
use Carbon\CarbonImmutable;
use RuntimeException;
use Symfony\Component\Process\Process;

final class SwissEphemerisService implements AstrologyEphemeris
{
    /**
     * @var array<string, string>
     */
    private const PLANET_CODES = [
        'sun' => '0',
        'moon' => '1',
        'mercury' => '2',
        'venus' => '3',
        'mars' => '4',
        'jupiter' => '5',
        'saturn' => '6',
        'uranus' => '7',
        'neptune' => '8',
        'pluto' => '9',
        'north_node' => 'm',
        'chiron' => 'D',
    ];

    public function planetLongitudes(CarbonImmutable $dateTime, array $planets): array
    {
        $planetSequence = $this->buildPlanetSequence($planets);
        if ($planetSequence === '') {
            return [];
        }

        $output = $this->runSwetest([
            '-b' . $dateTime->format('d.m.Y'),
            '-ut' . $dateTime->format('H:i:s'),
            '-p' . $planetSequence,
            '-eswe',
            '-fPl',
            '-g,',
            '-head',
        ]);

        return $this->parsePlanetOutput($output);
    }

    public function ascendantLongitude(
        CarbonImmutable $dateTime,
        float $latitude,
        float $longitude,
        string $houseSystem
    ): float {
        $houseCode = $this->resolveHouseSystemCode($houseSystem);

        $output = $this->runSwetest([
            '-b' . $dateTime->format('d.m.Y'),
            '-ut' . $dateTime->format('H:i:s'),
            '-house' . $longitude . ',' . $latitude . ',' . $houseCode,
            '-eswe',
            '-g,',
            '-head',
        ]);

        return $this->parseAscendantLongitude($output);
    }

    /**
     * @param array<string> $planets
     */
    private function buildPlanetSequence(array $planets): string
    {
        $sequence = '';

        foreach ($planets as $planet) {
            $key = strtolower($planet);
            if (!array_key_exists($key, self::PLANET_CODES)) {
                continue;
            }

            $sequence .= self::PLANET_CODES[$key];
        }

        return $sequence;
    }

    private function runSwetest(array $arguments): string
    {
        $swetestPath = (string) config('astrology.swetest_path');
        $ephemerisPath = (string) config('astrology.ephemeris_path');

        if (!is_file($swetestPath) || !is_executable($swetestPath)) {
            throw new RuntimeException('Swiss Ephemeris binary not found or not executable.');
        }

        $process = new Process(array_merge([
            $swetestPath,
            '-edir' . $ephemerisPath,
        ], $arguments));

        $process->run();

        if (!$process->isSuccessful()) {
            throw new RuntimeException('Swiss Ephemeris command failed: ' . $process->getErrorOutput());
        }

        return trim($process->getOutput());
    }

    /**
     * @return array<string, float>
     */
    private function parsePlanetOutput(string $output): array
    {
        $results = [];

        foreach (preg_split('/\r?\n/', $output) as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            $parts = str_getcsv($line);
            if (count($parts) < 2) {
                continue;
            }

            $planetName = strtolower(trim((string) $parts[0]));
            $planetName = preg_replace('/\s+/', '_', $planetName);

            $longitude = (float) $parts[1];

            $planetKey = $this->normalizePlanetKey($planetName);
            if ($planetKey === null) {
                continue;
            }

            $results[$planetKey] = $longitude;
        }

        return $results;
    }

    private function normalizePlanetKey(string $planetName): ?string
    {
        $aliases = [
            'sun' => Planet::Sun->value,
            'moon' => Planet::Moon->value,
            'mercury' => Planet::Mercury->value,
            'venus' => Planet::Venus->value,
            'mars' => Planet::Mars->value,
            'jupiter' => Planet::Jupiter->value,
            'saturn' => Planet::Saturn->value,
            'uranus' => Planet::Uranus->value,
            'neptune' => Planet::Neptune->value,
            'pluto' => Planet::Pluto->value,
            'mean_node' => Planet::NorthNode->value,
            'true_node' => Planet::NorthNode->value,
            'chiron' => Planet::Chiron->value,
        ];

        return $aliases[$planetName] ?? null;
    }

    private function resolveHouseSystemCode(string $houseSystem): string
    {
        $houseSystems = (array) config('astrology.house_systems', []);
        $key = strtolower($houseSystem);

        return (string) ($houseSystems[$key] ?? 'P');
    }

    private function parseAscendantLongitude(string $output): float
    {
        foreach (preg_split('/\r?\n/', $output) as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            $parts = str_getcsv($line);
            if ($parts === [] || !isset($parts[0], $parts[1])) {
                continue;
            }

            $label = strtolower((string) $parts[0]);
            if (!str_contains($label, 'asc')) {
                continue;
            }

            return (float) $parts[1];
        }

        if (preg_match('/asc[^0-9]*([0-9]+(?:\.[0-9]+)?)/i', $output, $match)) {
            return (float) $match[1];
        }

        throw new RuntimeException('Unable to parse ascendant from Swiss Ephemeris output.');
    }
}
