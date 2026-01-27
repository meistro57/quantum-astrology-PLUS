<?php

declare(strict_types=1);

return [
    'numerology' => [
        'enabled' => true,
        'features' => [
            'core_numbers' => true,
            'pythagorean_grid' => true,
            'personal_cycles' => true,
            'karmic_numbers' => true,
        ],
        'calculation_precision' => [
            'master_number_threshold' => 9,
            'reduction_method' => 'pythagorean',
        ],
    ],

    'integration' => [
        'astrology' => [
            'birth_chart_sync' => true,
            'planetary_number_mapping' => [
                'Sun' => 1,
                'Moon' => 2,
                'Mercury' => 5,
                'Venus' => 6,
                'Mars' => 3,
                'Jupiter' => 3,
                'Saturn' => 4,
                'Uranus' => 4,
                'Neptune' => 7,
                'Pluto' => 8,
            ],
        ],
        'cards' => [
            'birth_card_sync' => true,
            'numerology_card_mapping' => [
                1 => 'Magician',
                2 => 'High Priestess',
                3 => 'Empress',
                4 => 'Emperor',
                5 => 'Hierophant',
                6 => 'Lovers',
                7 => 'Chariot',
                8 => 'Strength',
                9 => 'Hermit',
                11 => 'Justice',
                22 => 'Wheel of Fortune',
                33 => 'Hanged Man',
            ],
        ],
    ],

    'performance' => [
        'cache_duration' => 60 * 24 * 30, // 30 days
        'cache_profile_calculations' => true,
    ],
];