<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Card Deck Configuration
    |--------------------------------------------------------------------------
    |
    | Standard 52-card deck used for Birth Card calculations.
    |
    */
    'suits' => ['hearts', 'clubs', 'diamonds', 'spades'],
    
    'values' => [
        'A' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7,
        '8' => 8, '9' => 9, '10' => 10, 'J' => 11, 'Q' => 12, 'K' => 13,
    ],

    /*
    |--------------------------------------------------------------------------
    | Suit Associations
    |--------------------------------------------------------------------------
    */
    'suit_meanings' => [
        'hearts' => [
            'element' => 'water',
            'realm' => 'emotions',
            'season' => 'summer',
            'keywords' => ['love', 'relationships', 'feelings', 'creativity'],
        ],
        'clubs' => [
            'element' => 'fire',
            'realm' => 'mind',
            'season' => 'spring',
            'keywords' => ['knowledge', 'communication', 'ideas', 'learning'],
        ],
        'diamonds' => [
            'element' => 'earth',
            'realm' => 'values',
            'season' => 'autumn',
            'keywords' => ['money', 'resources', 'worth', 'material'],
        ],
        'spades' => [
            'element' => 'air',
            'realm' => 'wisdom',
            'season' => 'winter',
            'keywords' => ['work', 'health', 'transformation', 'spirituality'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Planetary Periods
    |--------------------------------------------------------------------------
    |
    | Each 52-day period of the year is ruled by a planet.
    |
    */
    'planetary_periods' => [
        'mercury' => ['start' => 1, 'days' => 52],
        'venus' => ['start' => 53, 'days' => 52],
        'mars' => ['start' => 105, 'days' => 52],
        'jupiter' => ['start' => 157, 'days' => 52],
        'saturn' => ['start' => 209, 'days' => 52],
        'uranus' => ['start' => 261, 'days' => 52],
        'neptune' => ['start' => 313, 'days' => 52],
    ],

    /*
    |--------------------------------------------------------------------------
    | Solar Quadration
    |--------------------------------------------------------------------------
    |
    | 7x7 grid configuration for yearly spreads.
    |
    */
    'quadration' => [
        'rows' => 7,
        'columns' => 7,
        'total_cards' => 49,
        'planets_per_row' => ['mercury', 'venus', 'mars', 'jupiter', 'saturn', 'uranus', 'neptune'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Birth Card Calculation
    |--------------------------------------------------------------------------
    |
    | The Grand Solar Spread positions for each day of the year.
    | This is a simplified lookup - full implementation uses the complete spread.
    |
    */
    'use_grand_solar_spread' => true,

    /*
    |--------------------------------------------------------------------------
    | Planetary Ruling Cards
    |--------------------------------------------------------------------------
    |
    | Based on the ruling planet of each zodiac sign.
    |
    */
    'zodiac_rulers' => [
        'aries' => 'mars',
        'taurus' => 'venus',
        'gemini' => 'mercury',
        'cancer' => 'moon',
        'leo' => 'sun',
        'virgo' => 'mercury',
        'libra' => 'venus',
        'scorpio' => 'pluto',
        'sagittarius' => 'jupiter',
        'capricorn' => 'saturn',
        'aquarius' => 'uranus',
        'pisces' => 'neptune',
    ],

    /*
    |--------------------------------------------------------------------------
    | Card Keywords
    |--------------------------------------------------------------------------
    |
    | Brief meanings for face cards and aces.
    |
    */
    'face_cards' => [
        'A' => ['new beginnings', 'potential', 'seed', 'initiative'],
        'J' => ['youth', 'messenger', 'creative expression', 'risk-taking'],
        'Q' => ['intuition', 'receptivity', 'nurturing', 'service'],
        'K' => ['mastery', 'authority', 'expertise', 'completion'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    */
    'cache' => [
        'enabled' => true,
        'ttl' => 60 * 60 * 24 * 365, // 1 year (birth cards don't change)
        'prefix' => 'cards',
    ],
];
