<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Services\PersonalCyclesCalculator;
use Carbon\CarbonImmutable;
use PHPUnit\Framework\TestCase;

final class PersonalCyclesCalculatorTest extends TestCase
{
    private PersonalCyclesCalculator $calculator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->calculator = new PersonalCyclesCalculator();
    }

    public function testPersonalYearCalculation(): void
    {
        $birthDate = CarbonImmutable::create(1990, 6, 15);
        $targetDate = CarbonImmutable::create(2026, 1, 27);

        $personalYear = $this->calculator->calculatePersonalYear($birthDate, $targetDate);
        
        $this->assertIsInt($personalYear);
        $this->assertGreaterThan(0);
        $this->assertLessThanOrEqual(33);
    }

    public function testPersonalMonthCalculation(): void
    {
        $birthDate = CarbonImmutable::create(1990, 6, 15);
        $targetDate = CarbonImmutable::create(2026, 1, 27);

        $personalMonth = $this->calculator->calculatePersonalMonth($birthDate, $targetDate);
        
        $this->assertIsInt($personalMonth);
        $this->assertGreaterThan(0);
        $this->assertLessThanOrEqual(33);
    }

    public function testPersonalDayCalculation(): void
    {
        $birthDate = CarbonImmutable::create(1990, 6, 15);
        $targetDate = CarbonImmutable::create(2026, 1, 27);

        $personalDay = $this->calculator->calculatePersonalDay($birthDate, $targetDate);
        
        $this->assertIsInt($personalDay);
        $this->assertGreaterThan(0);
        $this->assertLessThanOrEqual(33);
    }

    public function testPersonalCyclesInterpretation(): void
    {
        $birthDate = CarbonImmutable::create(1990, 6, 15);
        $targetDate = CarbonImmutable::create(2026, 1, 27);

        $interpretations = $this->calculator->interpretPersonalCycles($birthDate, $targetDate);
        
        $this->assertArrayHasKey('personal_year', $interpretations);
        $this->assertArrayHasKey('personal_month', $interpretations);
        $this->assertArrayHasKey('personal_day', $interpretations);
        
        foreach ($interpretations as $cycle => $interpretation) {
            $this->assertIsString($interpretation);
            $this->assertNotEmpty($interpretation);
        }
    }

    public function testMasterNumberHandling(): void
    {
        $birthDate = CarbonImmutable::create(1990, 6, 15);
        
        // Test scenarios that might produce master numbers
        $testDates = [
            CarbonImmutable::create(2033, 11, 22),
            CarbonImmutable::create(2044, 5, 11)
        ];

        foreach ($testDates as $targetDate) {
            $personalYear = $this->calculator->calculatePersonalYear($birthDate, $targetDate);
            $this->assertTrue(
                in_array($personalYear, [1, 2, 3, 4, 5, 6, 7, 8, 9, 11, 22, 33]), 
                "Failed for date: {$targetDate}"
            );
        }
    }
}