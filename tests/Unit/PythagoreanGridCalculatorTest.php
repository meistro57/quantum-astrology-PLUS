<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Modules\Numerology\Services\PythagoreanGridCalculator;
use PHPUnit\Framework\TestCase;

final class PythagoreanGridCalculatorTest extends TestCase
{
    private PythagoreanGridCalculator $calculator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->calculator = new PythagoreanGridCalculator();
    }

    public function testGridCalculation(): void
    {
        $grid = $this->calculator->calculateGrid('1990-06-15');

        $this->assertSame([
            'grid_numbers' => [2, 0, 0, 0, 1, 1, 0, 0, 2],
            'grid_arrows' => ['Top-Left to Bottom-Right Diagonal'],
        ], $grid);
    }

    public function testGridInterpretations(): void
    {
        $grid = $this->calculator->calculateGrid('1990-06-15');
        $interpretations = $this->calculator->interpretGrid($grid);

        $this->assertArrayHasKey('number_1', $interpretations);
        $this->assertArrayHasKey('number_5', $interpretations);
        $this->assertArrayHasKey('number_6', $interpretations);
        $this->assertArrayHasKey('number_9', $interpretations);
        $this->assertArrayHasKey('arrow_top-left_to_bottom-right_diagonal', $interpretations);
    }
}
