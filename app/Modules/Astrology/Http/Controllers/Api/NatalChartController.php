<?php

declare(strict_types=1);

namespace App\Modules\Astrology\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Astrology\Http\Requests\CreateAstrologyChartRequest;
use App\Modules\Astrology\Http\Resources\NatalChartResource;
use App\Modules\Astrology\Services\AstrologyCalculator;
use Carbon\CarbonImmutable;

final class NatalChartController extends Controller
{
    public function __construct(
        private readonly AstrologyCalculator $calculator
    ) {}

    public function store(CreateAstrologyChartRequest $request): NatalChartResource
    {
        $validated = $request->validated();

        $dateTime = CarbonImmutable::parse($validated['datetime']);
        $latitude = (float) $validated['latitude'];
        $longitude = (float) $validated['longitude'];

        $chart = $this->calculator->calculateNatalChart(
            $dateTime,
            $latitude,
            $longitude
        );

        return NatalChartResource::fromDto($chart);
    }
}
