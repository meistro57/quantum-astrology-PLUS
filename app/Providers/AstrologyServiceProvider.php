<?php

declare(strict_types=1);

namespace App\Providers;

use App\Modules\Astrology\Services\AstrologyCalculator;
use Illuminate\Support\ServiceProvider;

final class AstrologyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(AstrologyCalculator::class, fn () => new AstrologyCalculator());
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
        return [AstrologyCalculator::class];
    }
}
