<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Services\NumerologyCalculator;
use Carbon\CarbonImmutable;
use PHPUnit\Framework\TestCase;

final class NumerologyCalculatorTest extends TestCase
{
    private NumerologyCalculator $calculator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->calculator = new NumerologyCalculator();
    }

    public function testLifePathCalculation(): void
    {
        $birthDate = CarbonImmutable::create(1990, 6, 15);
        $lifePath = $this->calculator->calculateLifePath($birthDate);
        $this->assertEquals(4, $lifePath);
    }

    public function testExpressionNumber(): void
    {
        $fullName = "John Albert Doe";
        $expressionNumber = $this->calculator->calculateExpression($fullName);
        $this->assertIsInt($expressionNumber);
    }

    public function testHeartsDesire(): void
    {
        $fullName = "John Albert Doe";
        $heartsDesire = $this->calculator->calculateHeartsDesire($fullName);
        $this->assertIsInt($heartsDesire);
    }

    public function testPersonalityNumber(): void
    {
        $fullName = "John Albert Doe";
        $personalityNumber = $this->calculator->calculatePersonality($fullName);
        $this->assertIsInt($personalityNumber);
    }

    public function testBirthdayNumber(): void
    {
        $birthDate = CarbonImmutable::create(1990, 6, 15);
        $birthdayNumber = $this->calculator->calculateBirthday($birthDate);
        $this->assertEquals(6, $birthdayNumber);
    }

    public function testMasterNumbers(): void
    {
        $this->assertTrue($this->calculator->isMasterNumber(11));
        $this->assertTrue($this->calculator->isMasterNumber(22));
        $this->assertTrue($this->calculator->isMasterNumber(33));
        $this->assertFalse($this->calculator->isMasterNumber(5));
    }

    public function testPinnacles(): void
    {
        $birthDate = CarbonImmutable::create(1990, 6, 15);
        $pinnacles = $this->calculator->calculatePinnacles($birthDate);
        
        $this->assertArrayHasKey('first', $pinnacles);
        $this->assertArrayHasKey('second', $pinnacles);
        $this->assertArrayHasKey('third', $pinnacles);
        $this->assertArrayHasKey('fourth', $pinnacles);
    }
}