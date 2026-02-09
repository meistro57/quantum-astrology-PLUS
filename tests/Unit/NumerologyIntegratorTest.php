<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Modules\Numerology\Services\NumerologyCalculator;
use App\Modules\Numerology\Services\PersonalCyclesCalculator;
use App\Modules\Numerology\Support\ModuleIntegration\NumerologyIntegrator;
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
        $this->assertSame(4, $numerologyProfile->lifePath);
        $this->assertSame(8, $numerologyProfile->expression);
        $this->assertSame(8, $numerologyProfile->heartsDesire);
        $this->assertSame(9, $numerologyProfile->personality);
        $this->assertSame(6, $numerologyProfile->birthday);
        $this->assertSame(4, $numerologyProfile->firstPinnacle);
        $this->assertFalse($numerologyProfile->hasMasterNumbers);
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
        $this->assertSame(4, $cardData['birth_number']);
        $this->assertSame('Emperor', $cardData['birth_card']);
        $this->assertSame('Strength', $cardData['expression_card']);
        $this->assertFalse($cardData['has_master_numbers']);
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

        $this->assertSame(6, $numerologyProfile->firstPinnacle);
    }
}
