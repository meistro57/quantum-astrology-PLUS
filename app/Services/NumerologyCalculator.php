<?php

declare(strict_types=1);

namespace App\Services;

use Carbon\CarbonImmutable;
use Exception;

final class NumerologyCalculator
{
    /**
     * Calculate Life Path Number from birthdate
     * 
     * @throws Exception If birth date is invalid
     */
    public function calculateLifePath(CarbonImmutable $birthDate): int
    {
        $dateString = $birthDate->format('Y-m-d');
        $digits = preg_replace('/[^0-9]/', '', $dateString);
        
        $sum = array_sum(str_split($digits));
        while ($sum > 9 && $sum !== 11 && $sum !== 22 && $sum !== 33) {
            $sum = array_sum(str_split((string)$sum));
        }
        
        return $sum;
    }

    /**
     * Calculate Expression Number from full name
     * Using Pythagorean Numerology system
     */
    public function calculateExpression(string $fullName): int
    {
        $fullName = strtoupper(preg_replace('/[^A-Za-z]/', '', $fullName));
        $sum = 0;
        
        $pythagoreanValues = [
            'A' => 1, 'B' => 2, 'C' => 3, 'D' => 4, 'E' => 5, 
            'F' => 6, 'G' => 7, 'H' => 8, 'I' => 9, 'J' => 1, 
            'K' => 2, 'L' => 3, 'M' => 4, 'N' => 5, 'O' => 6, 
            'P' => 7, 'Q' => 8, 'R' => 9, 'S' => 1, 'T' => 2, 
            'U' => 3, 'V' => 4, 'W' => 5, 'X' => 6, 'Y' => 7, 'Z' => 8
        ];
        
        foreach (str_split($fullName) as $letter) {
            $sum += $pythagoreanValues[$letter] ?? 0;
        }
        
        while ($sum > 9 && $sum !== 11 && $sum !== 22 && $sum !== 33) {
            $sum = array_sum(str_split((string)$sum));
        }
        
        return $sum;
    }

    /**
     * Calculate Heart's Desire (Soul Urge) Number from full name
     */
    public function calculateHeartsDesire(string $fullName): int
    {
        $vowels = ['A', 'E', 'I', 'O', 'U'];
        $fullName = strtoupper(preg_replace('/[^A-Za-z]/', '', $fullName));
        $sum = 0;
        
        $pythagoreanValues = [
            'A' => 1, 'E' => 5, 'I' => 9, 'O' => 6, 'U' => 3
        ];
        
        foreach (str_split($fullName) as $letter) {
            if (in_array($letter, $vowels)) {
                $sum += $pythagoreanValues[$letter] ?? 0;
            }
        }
        
        while ($sum > 9 && $sum !== 11 && $sum !== 22 && $sum !== 33) {
            $sum = array_sum(str_split((string)$sum));
        }
        
        return $sum;
    }

    /**
     * Calculate Personality Number from consonants in full name
     */
    public function calculatePersonality(string $fullName): int
    {
        $vowels = ['A', 'E', 'I', 'O', 'U'];
        $fullName = strtoupper(preg_replace('/[^A-Za-z]/', '', $fullName));
        $sum = 0;
        
        $pythagoreanValues = [
            'B' => 2, 'C' => 3, 'D' => 4, 'F' => 6, 'G' => 7, 
            'H' => 8, 'J' => 1, 'K' => 2, 'L' => 3, 'M' => 4, 
            'N' => 5, 'P' => 7, 'Q' => 8, 'R' => 9, 'S' => 1, 
            'T' => 2, 'V' => 4, 'W' => 5, 'X' => 6, 'Y' => 7, 'Z' => 8
        ];
        
        foreach (str_split($fullName) as $letter) {
            if (!in_array($letter, $vowels)) {
                $sum += $pythagoreanValues[$letter] ?? 0;
            }
        }
        
        while ($sum > 9 && $sum !== 11 && $sum !== 22 && $sum !== 33) {
            $sum = array_sum(str_split((string)$sum));
        }
        
        return $sum;
    }

    /**
     * Calculate Birthday Number (day of birth reduced)
     */
    public function calculateBirthday(CarbonImmutable $birthDate): int
    {
        $day = (int)$birthDate->format('d');
        
        while ($day > 9 && $day !== 11 && $day !== 22 && $day !== 33) {
            $day = array_sum(str_split((string)$day));
        }
        
        return $day;
    }

    /**
     * Detect Master Numbers (11, 22, 33)
     */
    public function isMasterNumber(int $number): bool
    {
        return in_array($number, [11, 22, 33]);
    }

    /**
     * Calculate Pinnacle numbers for life periods
     */
    public function calculatePinnacles(CarbonImmutable $birthDate): array
    {
        $month = (int)$birthDate->format('m');
        $day = (int)$birthDate->format('d');
        $year = (int)$birthDate->format('Y');
        
        $pinnacles = [
            'first' => $month + $day,
            'second' => $day + $year,
            // Third pinnacle is sum of first two
            'third' => $month + $day + $day + $year,
            // Fourth typically covers rest of life
            'fourth' => $month + $year
        ];
        
        // Reduce each pinnacle
        foreach ($pinnacles as &$pinnacle) {
            while ($pinnacle > 9 && $pinnacle !== 11 && $pinnacle !== 22 && $pinnacle !== 33) {
                $pinnacle = array_sum(str_split((string)$pinnacle));
            }
        }
        
        return $pinnacles;
    }
}