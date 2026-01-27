<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Services\NumerologyCalculator;
use App\Services\PersonalCyclesCalculator;
use App\Support\ModuleIntegration\NumerologyIntegrator;
use Carbon\CarbonImmutable;
use PHPUnit\Framework\TestCase;

final class NumerologyIntegratorTest extends TestCase
{
    private NumerologyIntegrator $integrator;
    private NumerologyCalculator $numerologyCalculator;
    private PersonalCyclesCalculator $cyclesCalculator;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->numerologyCalculator = new NumerologyCalculator();
        $this->cyclesCalculator = new PersonalCyclesCalculator();
        $this->integrator = new NumerologyIntegrator(
            $this->numerologyCalculator,
            $this->cyclesCalculator
        );
    }

    public function testSynchronizeWithAstrologyChart(): void
    {
        $birthDate = CarbonImmutable::create(1990, 6, 15);
        $astrologyChartData = [
            'birth_place' => 'New York',
            'planet_positions' => [
                'Sun' => ['sign' => 'Gemini', 'dignity' => 0.9],
                'Moon' => ['sign' => 'Scorpio', 'dignity' => 0.7],
            ]
        ];

        $numerologyProfile = $this->integrator->synchronizeWithAstrologyChart(
            1,
            'John Doe',
            $birthDate,
            $astrologyChartData
        );

        $this->assertNotNull($numerologyProfile);
        $this->assertEquals('John Doe', $numerologyProfile->fullName);
        $this->assertEquals($birthDate, $numerologyProfile->birthDate);
        
        // Verify core numbers are calculated
        $this->assertIsInt($numerologyProfile->lifePath);
        $this->assertIsInt($numerologyProfile->expression);
        $this->assertIsInt($numerologyProfile->heartsDesire);
    }

    public function testPrepareCardSystemData(): void
    {
        $birthDate = CarbonImmutable::create(1990, 6, 15);
        $astrologyChartData = [
            'birth_place' => 'New York',
            'planet_positions' => [
                'Sun' => ['sign' => 'Gemini', 'dignity' => 0.9],
            ]
        ];

        $numerologyProfile = $this->integrator->synchronizeWithAstrologyChart(
            1,
            'John Doe',
            $birthDate,
            $astrologyChartData
        );

        $cardData = $this->integrator->prepareCardSystemData($numerologyProfile);

        $this->assertArrayHasKey('birth_number', $cardData);
        $this->assertArrayHasKey('birth_card', $cardData);
        $this->assertArrayHasKey('expression_card', $cardData);
        $this->assertArrayHasKey('has_master_numbers', $cardData);
    }

    public function testPlanetaryInfluenceOnPinnacles(): void
    {
        $birthDate = CarbonImmutable::create(1990, 6, 15);
        $astrologyChartData = [
            'birth_place' => 'New York',
            'planet_positions' => [
                'Jupiter' => ['sign' => 'Leo', 'dignity' => 0.8],
            ]
        ];

        $numerologyProfile = $this->integrator->synchronizeWithAstrologyChart(
            1,
            'John Doe',
            $birthDate,
            $astrologyChartData
        );

        $this->assertNotNull($numerologyProfile->firstPinnacle);
    }
}