<?php

declare(strict_types=1);

namespace App\Modules\Numerology\Services;

use App\Modules\Numerology\Support\NumberReducer;
use Carbon\CarbonImmutable;

final class PersonalCyclesCalculator
{
    private NumberReducer $reducer;

    public function __construct(?NumberReducer $reducer = null)
    {
        $this->reducer = $reducer ?? new NumberReducer();
    }

    /**
     * Calculate Personal Year Number
     */
    public function calculatePersonalYear(
        CarbonImmutable $birthDate, 
        CarbonImmutable $targetDate
    ): int {
        $birthMonth = (int)$birthDate->format('m');
        $birthDay = (int)$birthDate->format('d');
        $targetYear = (int)$targetDate->format('Y');

        $personalYear = $birthMonth + $birthDay + $targetYear;
        
        return $this->reducer->reduce($personalYear);
    }

    /**
     * Calculate Personal Month Number
     */
    public function calculatePersonalMonth(
        CarbonImmutable $birthDate, 
        CarbonImmutable $targetDate
    ): int {
        $personalYear = $this->calculatePersonalYear($birthDate, $targetDate);
        $targetMonth = (int)$targetDate->format('m');

        $personalMonth = $personalYear + $targetMonth;
        
        return $this->reducer->reduce($personalMonth);
    }

    /**
     * Calculate Personal Day Number
     */
    public function calculatePersonalDay(
        CarbonImmutable $birthDate, 
        CarbonImmutable $targetDate
    ): int {
        $personalMonth = $this->calculatePersonalMonth($birthDate, $targetDate);
        $targetDay = (int)$targetDate->format('d');

        $personalDay = $personalMonth + $targetDay;
        
        return $this->reducer->reduce($personalDay);
    }

    /**
     * Get detailed interpretation of personal cycle numbers
     * 
     * @return array<string, string>
     */
    public function interpretPersonalCycles(
        CarbonImmutable $birthDate, 
        CarbonImmutable $targetDate
    ): array {
        $personalYear = $this->calculatePersonalYear($birthDate, $targetDate);
        $personalMonth = $this->calculatePersonalMonth($birthDate, $targetDate);
        $personalDay = $this->calculatePersonalDay($birthDate, $targetDate);

        return [
            'personal_year' => $this->interpretPersonalNumber($personalYear),
            'personal_month' => $this->interpretPersonalNumber($personalMonth),
            'personal_day' => $this->interpretPersonalNumber($personalDay)
        ];
    }

    /**
     * Provide interpretation for personal cycle numbers
     */
    private function interpretPersonalNumber(int $number): string
    {
        $interpretations = [
            1 => 'New beginnings, independence, and leadership',
            2 => 'Cooperation, partnerships, and diplomacy',
            3 => 'Creativity, self-expression, and communication',
            4 => 'Stability, hard work, and foundation building',
            5 => 'Change, freedom, and adaptability',
            6 => 'Responsibility, love, and harmony',
            7 => 'Spiritual growth, introspection, and analysis',
            8 => 'Personal power, material success, and achievement',
            9 => 'Completion, humanitarianism, and universal love',
            11 => 'Spiritual enlightenment, intuition, and inspiration',
            22 => 'Master builder, large-scale achievements, and spiritual mastery',
            33 => 'Spiritual teaching, compassion, and global consciousness'
        ];

        return $interpretations[$number] ?? 'Unique personal energy';
    }
}
