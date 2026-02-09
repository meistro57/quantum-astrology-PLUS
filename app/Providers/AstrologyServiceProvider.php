<?php

declare(strict_types=1);

namespace App\Providers;

use App\Modules\Astrology\Services\AstrologyCalculator;
use App\Modules\Astrology\Services\AstrologyEphemeris;
use App\Modules\Astrology\Services\DeterministicEphemeris;
use App\Modules\Astrology\Services\SwissEphemerisService;
use Illuminate\Support\ServiceProvider;

final class AstrologyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(AstrologyEphemeris::class, function () {
            $driver = (string) config('astrology.ephemeris_driver', 'swetest');

            if ($driver === 'deterministic') {
                return new DeterministicEphemeris();
            }

            return new SwissEphemerisService();
        });
        $this->app->singleton(
            AstrologyCalculator::class,
            fn () => new AstrologyCalculator($this->app->make(AstrologyEphemeris::class))
        );
    }

    public function isDeferred(): bool
    {
        return true;
    }

    /**
     * @return array<class-string>
     */
    public function provides(): array
    {
        return [AstrologyCalculator::class, AstrologyEphemeris::class];
    }
}
