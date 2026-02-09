<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Modules\Numerology\Services\PersonalCyclesCalculator;
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

    public function testPersonalCyclesForTargetDate(): void
    {
        $birthDate = CarbonImmutable::create(1990, 6, 15);
        $targetDate = CarbonImmutable::create(2026, 2, 9);

        $this->assertSame(4, $this->calculator->calculatePersonalYear($birthDate, $targetDate));
        $this->assertSame(6, $this->calculator->calculatePersonalMonth($birthDate, $targetDate));
        $this->assertSame(6, $this->calculator->calculatePersonalDay($birthDate, $targetDate));
    }

    public function testPersonalCycleInterpretations(): void
    {
        $birthDate = CarbonImmutable::create(1990, 6, 15);
        $targetDate = CarbonImmutable::create(2026, 2, 9);

        $interpretations = $this->calculator->interpretPersonalCycles($birthDate, $targetDate);

        $this->assertSame([
            'personal_year' => 'Stability, hard work, and foundation building',
            'personal_month' => 'Responsibility, love, and harmony',
            'personal_day' => 'Responsibility, love, and harmony',
        ], $interpretations);
    }
}
