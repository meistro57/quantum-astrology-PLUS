<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Pythagorean Letter Values
    |--------------------------------------------------------------------------
    |
    | Standard Western numerology letter-to-number mapping.
    |
    */
    'pythagorean' => [
        'a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5, 'f' => 6, 'g' => 7, 'h' => 8, 'i' => 9,
        'j' => 1, 'k' => 2, 'l' => 3, 'm' => 4, 'n' => 5, 'o' => 6, 'p' => 7, 'q' => 8, 'r' => 9,
        's' => 1, 't' => 2, 'u' => 3, 'v' => 4, 'w' => 5, 'x' => 6, 'y' => 7, 'z' => 8,
    ],

    /*
    |--------------------------------------------------------------------------
    | Vowels and Consonants
    |--------------------------------------------------------------------------
    */
    'vowels' => ['a', 'e', 'i', 'o', 'u'],
    
    // Y is sometimes a vowel - handled contextually
    'y_as_vowel_rules' => [
        'at_end_of_name' => true,
        'only_vowel_in_syllable' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Master Numbers
    |--------------------------------------------------------------------------
    |
    | Numbers that are not reduced further.
    |
    */
    'master_numbers' => [11, 22, 33],

    /*
    |--------------------------------------------------------------------------
    | Karmic Debt Numbers
    |--------------------------------------------------------------------------
    */
    'karmic_debt' => [13, 14, 16, 19],

    /*
    |--------------------------------------------------------------------------
    | Karmic Lesson Detection
    |--------------------------------------------------------------------------
    |
    | Missing numbers in full birth name indicate karmic lessons.
    |
    */
    'karmic_lessons' => true,

    /*
    |--------------------------------------------------------------------------
    | Pinnacle Calculation Ages
    |--------------------------------------------------------------------------
    |
    | Life Path determines first pinnacle end age.
    | Formula: 36 - Life Path = End of First Pinnacle
    |
    */
    'pinnacle_base_age' => 36,

    /*
    |--------------------------------------------------------------------------
    | Arrows of Pythagoras
    |--------------------------------------------------------------------------
    |
    | Grid positions for arrow detection.
    |
    */
    'arrows' => [
        // Arrows of Strength (present numbers)
        'determination' => [1, 5, 9],      // Diagonal
        'spirituality' => [3, 5, 7],       // Diagonal
        'intellect' => [3, 6, 9],          // Top row
        'emotion' => [2, 5, 8],            // Middle column
        'practicality' => [1, 4, 7],       // Left column
        'will' => [4, 5, 6],               // Middle row
        'action' => [7, 8, 9],             // Bottom row
        'planner' => [1, 2, 3],            // Top row
        
        // Arrows of Weakness (missing numbers)
        'frustration' => [4, 5, 6],        // Missing middle row
        'hesitation' => [1, 5, 9],         // Missing diagonal
        'loneliness' => [3, 5, 7],         // Missing diagonal
        'indecision' => [2, 5, 8],         // Missing middle column
        'poor_memory' => [3, 6, 9],        // Missing right column
        'emotional_sensitivity' => [2, 5, 8],
        'lost_purpose' => [7, 8, 9],       // Missing bottom row
        'skepticism' => [1, 2, 3],         // Missing top row
    ],

    /*
    |--------------------------------------------------------------------------
    | Personal Year Cycle
    |--------------------------------------------------------------------------
    |
    | 9-year cycle starting from birth.
    |
    */
    'cycle_length' => 9,

    /*
    |--------------------------------------------------------------------------
    | Number Meanings
    |--------------------------------------------------------------------------
    |
    | Brief keywords for each number.
    |
    */
    'meanings' => [
        1 => ['independence', 'leadership', 'initiative', 'new beginnings'],
        2 => ['cooperation', 'balance', 'partnership', 'diplomacy'],
        3 => ['creativity', 'expression', 'joy', 'communication'],
        4 => ['stability', 'structure', 'hard work', 'foundation'],
        5 => ['freedom', 'change', 'adventure', 'versatility'],
        6 => ['responsibility', 'love', 'nurturing', 'harmony'],
        7 => ['spirituality', 'analysis', 'wisdom', 'introspection'],
        8 => ['abundance', 'power', 'achievement', 'material success'],
        9 => ['completion', 'humanitarianism', 'wisdom', 'letting go'],
        11 => ['intuition', 'inspiration', 'illumination', 'visionary'],
        22 => ['master builder', 'large-scale achievement', 'practical idealism'],
        33 => ['master teacher', 'compassion', 'healing', 'blessing'],
    ],
];
