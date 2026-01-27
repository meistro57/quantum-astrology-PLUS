<?php

declare(strict_types=1);

namespace App\Support\ModuleIntegration;

use App\DTOs\Numerology\NumerologyProfileData;
use App\Models\NumerologyProfile;
use App\Services\NumerologyCalculator;
use App\Services\PersonalCyclesCalculator;
use Carbon\CarbonImmutable;

final class NumerologyIntegrator
{
    public function __construct(
        private readonly NumerologyCalculator $numerologyCalculator,
        private readonly PersonalCyclesCalculator $cyclesCalculator
    ) {}

    /**
     * Synchronize numerology profile with astrological birth chart
     */
    public function synchronizeWithAstrologyChart(
        int $userId, 
        string $fullName, 
        CarbonImmutable $birthDate, 
        array $astrologyChartData
    ): NumerologyProfileData {
        // Extract relevant data from astrology chart
        $birthPlace = $astrologyChartData['birth_place'] ?? null;
        $dominantPlanet = $this->extractDominantPlanet($astrologyChartData);

        // Calculate numerology profile
        $lifePath = $this->numerologyCalculator->calculateLifePath($birthDate);
        $expression = $this->numerologyCalculator->calculateExpression($fullName);
        
        // Use planetary information to enhance calculations
        $personalYearModifier = $this->calculatePlanetaryInfluence($dominantPlanet);

        // Create enhanced numerology profile
        return new NumerologyProfileData(
            userId: $userId,
            fullName: $fullName,
            birthDate: $birthDate,
            lifePath: $lifePath,
            expression: $expression,
            heartsDesire: $this->numerologyCalculator->calculateHeartsDesire($fullName),
            personality: $this->numerologyCalculator->calculatePersonality($fullName),
            birthday: $this->numerologyCalculator->calculateBirthday($birthDate),
            // Add planetary modifier to pinnacles
            firstPinnacle: $this->modifyPinnacle(
                $this->numerologyCalculator->calculatePinnacles($birthDate)['first'], 
                $personalYearModifier
            ),
            // Additional fields left for brevity
            hasMasterNumbers: $this->numerologyCalculator->isMasterNumber($lifePath)
        );
    }

    /**
     * Extract dominant planet from astrology chart
     */
    private function extractDominantPlanet(array $astrologyChartData): ?string
    {
        $planetPositions = $astrologyChartData['planet_positions'] ?? [];
        
        // Find planet with highest dignity or closest to midheaven
        return collect($planetPositions)
            ->sortByDesc(fn($position) => $position['dignity'] ?? 0)
            ->keys()
            ->first();
    }

    /**
     * Calculate planetary influence on numerology
     */
    private function calculatePlanetaryInfluence(?string $planet): int
    {
        $planetaryModifiers = [
            'Sun' => 1,
            'Moon' => 2,
            'Mercury' => 5,
            'Venus' => 6,
            'Mars' => 3,
            'Jupiter' => 3,
            'Saturn' => 4,
            'Uranus' => 4,
            'Neptune' => 7,
            'Pluto' => 8
        ];

        return $planetaryModifiers[$planet] ?? 0;
    }

    /**
     * Modify pinnacle with planetary influence
     */
    private function modifyPinnacle(int $pinnacle, int $modifier): int
    {
        $modifiedPinnacle = $pinnacle + $modifier;
        
        // Reduce to single digit or master number
        while ($modifiedPinnacle > 9 && 
               $modifiedPinnacle !== 11 && 
               $modifiedPinnacle !== 22 && 
               $modifiedPinnacle !== 33) {
            $modifiedPinnacle = array_sum(str_split((string)$modifiedPinnacle));
        }

        return $modifiedPinnacle;
    }

    /**
     * Generate card system synchronization data
     */
    public function prepareCardSystemData(NumerologyProfileData $numerologyProfile): array
    {
        $cardMappings = config('modules.integration.cards.numerology_card_mapping', []);

        return [
            'birth_number' => $numerologyProfile->lifePath,
            'birth_card' => $cardMappings[$numerologyProfile->lifePath] ?? null,
            'expression_card' => $cardMappings[$numerologyProfile->expression] ?? null,
            'has_master_numbers' => $numerologyProfile->hasMasterNumbers,
        ];
    }
}