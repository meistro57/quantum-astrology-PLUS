<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Modules\Numerology\Support\NumberReducer;
use PHPUnit\Framework\TestCase;

final class NumberReducerTest extends TestCase
{
    public function testReducePreservesMasterNumbers(): void
    {
        $reducer = new NumberReducer();

        $this->assertSame(11, $reducer->reduce(11));
        $this->assertSame(22, $reducer->reduce(22));
        $this->assertSame(33, $reducer->reduce(33));
    }

    public function testReduceToSingleDigit(): void
    {
        $reducer = new NumberReducer();

        $this->assertSame(4, $reducer->reduce(31));
        $this->assertSame(6, $reducer->reduce(15));
    }
}
