# Numerology Module Documentation

## Overview

The Numerology module is a comprehensive system for calculating and interpreting numerological insights based on an individual's birth data. It provides deep, meaningful analysis of personal numbers, grid patterns, and life cycles.

## Core Concepts

### Numerological Calculations

The module calculates several key numbers derived from a person's full name and birth date:

1. **Core Numbers**:
   - Life Path
   - Expression (Destiny)
   - Heart's Desire
   - Personality
   - Birthday Number

2. **Advanced Calculations**:
   - Pinnacles (4 life periods)
   - Pythagorean Grid
   - Personal Cycles (Year/Month/Day)
   - Master Number Detection

### Calculation Methods

#### Life Path Number
- Derived from birth date
- Reduces to single digit or master number (11, 22, 33)
- Represents life's core purpose and direction

#### Expression Number
- Calculated from full name using Pythagorean numerology
- Reveals personal talents, abilities, and life goals

#### Heart's Desire Number
- Calculated from vowels in full name
- Represents inner motivations and emotional drives

#### Pythagorean Grid

The grid is a 3x3 matrix representing number occurrences in birth date:

```
1 2 3
4 5 6
7 8 9
```

Features:
- Detects number frequencies
- Identifies "Arrows of Pythagoras"
- Provides insights into personality strengths and challenges

## API Endpoints

### Profile Management

- `GET /api/numerology/profiles`
  - List user's numerology profiles
  - Requires authentication

- `POST /api/numerology/profiles`
  - Create a new numerology profile
  - Requires:
    - `full_name`: String (letters only)
    - `birth_date`: Date (YYYY-MM-DD)

- `GET /api/numerology/profiles/{id}`
  - Retrieve specific profile details

- `DELETE /api/numerology/profiles/{id}`
  - Remove a numerology profile

### Personal Cycles

- `GET /api/numerology/profiles/{id}/cycles/{date}`
  - Calculate personal cycles for a specific date
  - Returns:
    - Personal Year Number
    - Personal Month Number
    - Personal Day Number

## Validation Rules

- Names: Letters, spaces, hyphens, apostrophes
- Birth Date:
  - Must be in the past
  - Format: YYYY-MM-DD

## Example Calculations

### Life Path Calculation
```php
$birthDate = CarbonImmutable::create(1990, 6, 15);
$lifePath = $numerologyCalculator->calculateLifePath($birthDate);
// Result: 4 (Stability, hard work)
```

### Grid Calculation
```php
$gridData = $gridCalculator->calculateGrid('1990-06-15');
// Returns grid numbers and detected arrows
```

## Interpretation Examples

### Life Path 4
- **Characteristics**: 
  - Practical
  - Disciplined
  - Reliable
  - Focused on building stable foundations

### Master Number 11
- **Characteristics**:
  - Spiritual intuition
  - Inspirational leadership
  - High spiritual potential
  - Requires personal mastery

## Performance Considerations

- Calculations are computationally lightweight
- Results can be cached
- Designed for rapid, real-time calculation

## Security

- All endpoints require authentication
- Users can only access their own profiles
- Strict input validation
- Immutable data handling

## Error Handling

Possible error scenarios:
- Invalid birth date
- Name format violations
- Unauthorized access attempts

## Future Enhancements

- Machine learning-based interpretations
- More detailed cycle predictions
- Comparative numerology analysis

## Technical Dependencies

- Laravel 12
- PHP 8.4+
- Carbon for date manipulation
- Pest PHP for testing

## Integration Notes

- Designed to work seamlessly with Astrology and Cards modules
- Follows Quantum Minds United's type-safe, immutable design principles

---

*Generated for Quantum Astrology PLUS*
*Last Updated: January 2026*