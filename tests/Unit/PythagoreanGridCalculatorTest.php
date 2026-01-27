<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Services\PythagoreanGridCalculator;
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
        $birthdate = '1990-06-15';
        $gridResult = $this->calculator->calculateGrid($birthdate);

        $this->assertArrayHasKey('grid_numbers', $gridResult);
        $this->assertArrayHasKey('grid_arrows', $gridResult);
        $this->assertCount(9, $gridResult['grid_numbers']);
        $this->assertIsArray($gridResult['grid_arrows']);
    }

    public function testArrowDetection(): void
    {
        $testCases = [
            '1990-06-15' => ['grid_numbers' => [1,1,1,1,1,1,1,1,1]],
            '2000-01-01' => ['grid_numbers' => [1,1,1,0,0,0,0,0,0]]
        ];

        foreach ($testCases as $birthdate => $gridData) {
            $interpretations = $this->calculator->interpretGrid($gridData);
            $this->assertIsArray($interpretations);
        }
    }

    public function testGridInterpretation(): void
    {
        $gridData = [
            'grid_numbers' => [1,2,3,0,0,0,0,0,0],
            'grid_arrows' => ['Top Row']
        ];

        $interpretations = $this->calculator->interpretGrid($gridData);

        $this->assertArrayHasKey('number_1', $interpretations);
        $this->assertArrayHasKey('number_2', $interpretations);
        $this->assertArrayHasKey('number_3', $interpretations);
        $this->assertArrayHasKey('arrow_top_row', $interpretations);
    }
}