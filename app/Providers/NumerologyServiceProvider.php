<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\NumerologyCalculator;
use App\Services\PersonalCyclesCalculator;
use App\Services\PythagoreanGridCalculator;
use Illuminate\Support\ServiceProvider;

final class NumerologyServiceProvider extends ServiceProvider
{
    /**
     * Register numerology-related services
     */
    public function register(): void
    {
        $this->app->singleton(NumerologyCalculator::class, fn () => 
            new NumerologyCalculator()
        );

        $this->app->singleton(PythagoreanGridCalculator::class, fn () => 
            new PythagoreanGridCalculator()
        );

        $this->app->singleton(PersonalCyclesCalculator::class, fn () => 
            new PersonalCyclesCalculator()
        );
    }

    /**
     * Bootstrap any application services
     */
    public function boot(): void
    {
        // Configuration publishing
        $this->publishes([
            __DIR__ . '/../../config/modules.php' => config_path('modules.php')
        ], 'numerology-config');

        // Migration publishing
        $this->publishes([
            __DIR__ . '/../../database/migrations/2026_01_27_create_numerology_profiles_table.php' 
            => database_path('migrations/2026_01_27_create_numerology_profiles_table.php')
        ], 'numerology-migrations');
    }

    /**
     * Determine if the provider should be deferred
     */
    public function isDeferred(): bool
    {
        return true;
    }

    /**
     * Get the services provided by this provider
     *
     * @return array<class-string>
     */
    public function provides(): array
    {
        return [
            NumerologyCalculator::class,
            PythagoreanGridCalculator::class,
            PersonalCyclesCalculator::class
        ];
    }
}