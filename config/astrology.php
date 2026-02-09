<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Swiss Ephemeris Configuration
    |--------------------------------------------------------------------------
    |
    | Path to the swetest binary and ephemeris data files.
    |
    */
    'ephemeris_driver' => env('ASTROLOGY_EPHEMERIS_DRIVER', 'swetest'),
    'swetest_path' => env('SWETEST_PATH', '/usr/local/bin/swetest'),
    'ephemeris_path' => env('EPHEMERIS_PATH', storage_path('app/ephemeris')),

    /*
    |--------------------------------------------------------------------------
    | Default Chart Settings
    |--------------------------------------------------------------------------
    */
    'defaults' => [
        'house_system' => env('DEFAULT_HOUSE_SYSTEM', 'placidus'),
        'zodiac_type' => env('DEFAULT_ZODIAC_TYPE', 'tropical'),
        'aspects' => ['conjunction', 'opposition', 'trine', 'square', 'sextile', 'quincunx'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Aspect Orbs
    |--------------------------------------------------------------------------
    |
    | Default orb allowances for each aspect type in degrees.
    | Luminaries (Sun/Moon) automatically get +2 degrees.
    |
    */
    'orbs' => [
        'conjunction' => 8.0,
        'opposition' => 8.0,
        'trine' => 7.0,
        'square' => 7.0,
        'sextile' => 5.0,
        'quincunx' => 3.0,
        'semisextile' => 2.0,
        'semisquare' => 2.0,
        'sesquisquare' => 2.0,
        'quintile' => 1.5,
        'biquintile' => 1.5,
    ],

    /*
    |--------------------------------------------------------------------------
    | Planets to Calculate
    |--------------------------------------------------------------------------
    */
    'planets' => [
        'sun', 'moon', 'mercury', 'venus', 'mars',
        'jupiter', 'saturn', 'uranus', 'neptune', 'pluto',
        'north_node', 'chiron',
    ],

    /*
    |--------------------------------------------------------------------------
    | House Systems
    |--------------------------------------------------------------------------
    */
    'house_systems' => [
        'placidus' => 'P',
        'koch' => 'K',
        'equal' => 'E',
        'whole_sign' => 'W',
        'campanus' => 'C',
        'regiomontanus' => 'R',
        'porphyry' => 'O',
        'morinus' => 'M',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    */
    'cache' => [
        'enabled' => true,
        'ttl' => 60 * 60 * 24 * 30, // 30 days
        'prefix' => 'astrology',
    ],
];
