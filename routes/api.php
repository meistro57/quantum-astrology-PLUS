<?php

use App\Modules\Astrology\Http\Controllers\Api\NatalChartController;
use App\Modules\Numerology\Http\Controllers\Api\NumerologyProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('astrology')->group(function () {
        Route::post('charts', [NatalChartController::class, 'store'])
            ->name('astrology.charts.store');
    });

    Route::prefix('numerology')->group(function () {
        Route::apiResource('profiles', NumerologyProfileController::class)
            ->only(['index', 'store', 'show', 'destroy']);
        
        Route::get('profiles/{profile}/cycles/{targetDate}', 
            [NumerologyProfileController::class, 'personalCycles']
        )->name('numerology.profiles.cycles');
    });
});
