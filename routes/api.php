<?php

use App\Http\Controllers\Api\Numerology\NumerologyProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('numerology')->group(function () {
        Route::apiResource('profiles', NumerologyProfileController::class)
            ->only(['index', 'store', 'show', 'destroy']);
        
        Route::get('profiles/{profile}/cycles/{targetDate}', 
            [NumerologyProfileController::class, 'personalCycles']
        )->name('numerology.profiles.cycles');
    });
});