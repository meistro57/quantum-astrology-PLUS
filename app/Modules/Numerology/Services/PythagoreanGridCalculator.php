<?php

declare(strict_types=1);

namespace App\Modules\Numerology\Services;

final class PythagoreanGridCalculator
{
    /**
     * Grid layout as defined in Pythagorean numerology
     * 
     * @var array<int, array<int>>
     */
    private const GRID_LAYOUT = [
        [1, 2, 3],
        [4, 5, 6],
        [7, 8, 9]
    ];

    /**
     * Calculate Pythagorean Grid from birthdate
     * 
     * @param string $birthdate Formatted as YYYY-MM-DD
     * @return array{grid_numbers: array<int>, grid_arrows: array<string>}
     */
    public function calculateGrid(string $birthdate): array
    {
        // Extract all digits from birthdate
        $digits = array_map('intval', 
            array_filter(str_split(str_replace(['-', ' ', '/'], '', $birthdate)))
        );

        // Initialize grid tracking
        $gridNumbers = array_fill(0, 9, 0);
        
        // Count occurrences of each number in the grid
        foreach ($digits as $digit) {
            if ($digit > 0 && $digit <= 9) {
                $gridNumbers[$digit - 1]++;
            }
        }

        return [
            'grid_numbers' => $gridNumbers,
            'grid_arrows' => $this->detectArrows($gridNumbers)
        ];
    }

    /**
     * Detect Arrows of Pythagoras based on grid numbers
     * 
     * @param array<int> $gridNumbers Counts of numbers in the grid
     * @return array<string> Detected arrows
     */
    private function detectArrows(array $gridNumbers): array
    {
        $arrows = [];

        // Horizontal Arrows (Rows)
        if ($this->isRowFull(0, $gridNumbers)) $arrows[] = 'Top Row';
        if ($this->isRowFull(1, $gridNumbers)) $arrows[] = 'Middle Row';
        if ($this->isRowFull(2, $gridNumbers)) $arrows[] = 'Bottom Row';

        // Vertical Arrows (Columns)
        if ($this->isColumnFull(0, $gridNumbers)) $arrows[] = 'Left Column';
        if ($this->isColumnFull(1, $gridNumbers)) $arrows[] = 'Middle Column';
        if ($this->isColumnFull(2, $gridNumbers)) $arrows[] = 'Right Column';

        // Diagonal Arrows
        if ($this->isDiagonalFull(true, $gridNumbers)) $arrows[] = 'Top-Left to Bottom-Right Diagonal';
        if ($this->isDiagonalFull(false, $gridNumbers)) $arrows[] = 'Top-Right to Bottom-Left Diagonal';

        return $arrows;
    }

    /**
     * Check if a specific row is completely filled
     * 
     * @param int $rowIndex Row index (0-2)
     * @param array<int> $gridNumbers Grid number counts
     */
    private function isRowFull(int $rowIndex, array $gridNumbers): bool
    {
        $rowNumbers = [
            [0, 1, 2],
            [3, 4, 5],
            [6, 7, 8]
        ][$rowIndex];

        return array_reduce($rowNumbers, 
            fn($carry, $num) => $carry && $gridNumbers[$num] > 0, 
            true
        );
    }

    /**
     * Check if a specific column is completely filled
     * 
     * @param int $colIndex Column index (0-2)
     * @param array<int> $gridNumbers Grid number counts
     */
    private function isColumnFull(int $colIndex, array $gridNumbers): bool
    {
        $colNumbers = [
            [0, 3, 6],
            [1, 4, 7],
            [2, 5, 8]
        ][$colIndex];

        return array_reduce($colNumbers, 
            fn($carry, $num) => $carry && $gridNumbers[$num] > 0, 
            true
        );
    }

    /**
     * Check if a diagonal is completely filled
     * 
     * @param bool $mainDiagonal True for top-left to bottom-right, false for top-right to bottom-left
     * @param array<int> $gridNumbers Grid number counts
     */
    private function isDiagonalFull(bool $mainDiagonal, array $gridNumbers): bool
    {
        $diagonalNumbers = $mainDiagonal 
            ? [0, 4, 8]   // Top-left to bottom-right
            : [2, 4, 6];  // Top-right to bottom-left

        return array_reduce($diagonalNumbers, 
            fn($carry, $num) => $carry && $gridNumbers[$num] > 0, 
            true
        );
    }

    /**
     * Interpret grid numbers and arrows
     * 
     * @param array{grid_numbers: array<int>, grid_arrows: array<string>} $gridData
     * @return array<string, string> Interpretations of grid
     */
    public function interpretGrid(array $gridData): array
    {
        $interpretations = [];

        // Number Interpretations
        foreach ($gridData['grid_numbers'] as $index => $count) {
            if ($count > 0) {
                $interpretations['number_' . ($index + 1)] = 
                    $this->interpretGridNumber($index + 1, $count);
            }
        }

        // Arrow Interpretations
        foreach ($gridData['grid_arrows'] as $arrow) {
            $interpretations['arrow_' . strtolower(str_replace(' ', '_', $arrow))] = 
                $this->interpretArrow($arrow);
        }

        return $interpretations;
    }

    /**
     * Provide interpretation for a specific grid number
     */
    private function interpretGridNumber(int $number, int $count): string
    {
        $interpretations = [
            1 => 'Leadership, independence, and individuality',
            2 => 'Cooperation, sensitivity, and diplomacy',
            3 => 'Creativity, self-expression, and communication',
            4 => 'Stability, discipline, and hard work',
            5 => 'Freedom, change, and adaptability',
            6 => 'Harmony, responsibility, and love',
            7 => 'Spirituality, analysis, and introspection',
            8 => 'Power, material success, and ambition',
            9 => 'Compassion, humanitarianism, and completion'
        ];

        $multiplicity = match(true) {
            $count === 1 => 'Single occurrence suggests potential growth',
            $count === 2 => 'Multiple occurrences indicate strength in this area',
            $count >= 3 => 'Dominant energy and significant life theme',
            default => ''
        };

        return sprintf('%s (Appears %d time(s)). %s', 
            $interpretations[$number] ?? 'Unknown', 
            $count, 
            $multiplicity
        );
    }

    /**
     * Provide interpretation for a specific arrow
     */
    private function interpretArrow(string $arrow): string
    {
        $interpretations = [
            'Top Row' => 'Mental strength, intellectual pursuits',
            'Middle Row' => 'Emotional balance, interpersonal skills',
            'Bottom Row' => 'Physical energy, practical achievements',
            'Left Column' => 'Willpower, self-motivation',
            'Middle Column' => 'Emotional intelligence, adaptability',
            'Right Column' => 'Intuition, spiritual awareness',
            'Top-Left to Bottom-Right Diagonal' => 'Balanced life path, harmonizing mind and body',
            'Top-Right to Bottom-Left Diagonal' => 'Spiritual growth through challenges'
        ];

        return $interpretations[$arrow] ?? 'Unique life path configuration';
    }
}
