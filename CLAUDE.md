# CLAUDE.md - Quantum Astrology PLUS

## Project Overview

**Quantum Astrology PLUS** is a comprehensive metaphysical toolkit combining Astrology, Numerology, and Card Systems into a unified Laravel application. This is the evolution of [quantum-astrology](https://github.com/meistro57/quantum-astrology), rebuilt from scratch with Laravel 12 + Inertia + React.

**Owner**: Mark Jasinski @ [Quantum Minds United](https://quantummindsunited.com)

---

## Tech Stack

- **Backend**: Laravel 12, PHP 8.4+
- **Frontend**: React 19, TypeScript, Inertia.js
- **Styling**: Tailwind CSS (cosmic/dark space theme)
- **Database**: MySQL 8+ or SQLite
- **Testing**: Pest PHP (target 100% coverage)
- **Astrology Engine**: Swiss Ephemeris (swetest CLI)

---

## Modules

### 1. Astrology Module (port from quantum-astrology)
- Swiss Ephemeris integration via CLI
- Natal chart generation with SVG wheel
- Planetary positions, house cusps, aspects
- Transit analysis
- Support for multiple house systems (Placidus, Koch, Equal, Whole Sign, etc.)

### 2. Numerology Module (NEW)
- **Core Numbers**: Life Path, Expression, Heart's Desire, Personality, Birthday, Attitude
- **Pythagorean Grid**: 3x3 grid with Arrows of Pythagoras (strength/weakness detection)
- **Pinnacles & Challenges**: 4 life periods with peak numbers
- **Personal Cycles**: Year, Month, Day numbers
- **Karmic Numbers**: Debt (13, 14, 16, 19) and Lessons (missing numbers in name)
- **Master Numbers**: 11, 22, 33 (not reduced)

### 3. Cards Module (NEW)
- Birth Card from birthday (Book of Destiny system)
- Planetary Ruling Card based on zodiac sign ruler
- 7×7 Solar Quadration yearly spreads
- Planetary period interpretations (Mercury through Neptune, 52 days each)

---

## Architecture Decisions

### Follow Laravel Best Practices
- **Actions**: Single-responsibility classes for discrete operations (e.g., `CreateChartAction`, `CalculateLifePathAction`)
- **DTOs**: Immutable data transfer objects with `readonly` classes
- **Enums**: PHP 8.1+ enums for all fixed values (planets, signs, aspects, etc.)
- **Services**: Business logic and external integrations (e.g., `SwissEphemerisService`, `NumerologyCalculator`)
- **Form Requests**: Validation logic in dedicated request classes
- **API Resources**: JSON transformation for API responses

### Directory Structure
```
app/
├── Actions/
│   ├── Astrology/
│   ├── Numerology/
│   └── Cards/
├── DTOs/
├── Enums/
├── Http/
│   ├── Controllers/Api/
│   ├── Requests/
│   └── Resources/
├── Models/
├── Modules/           # Module-specific logic if needed
│   ├── Astrology/
│   ├── Numerology/
│   └── Cards/
└── Services/
```

### Database Tables
- `users` - Authentication with subscription tiers (free/pro/premium)
- `charts` - Astrology charts with type, datetime, location, settings
- `planet_positions` - Calculated positions per chart
- `house_cusps` - House cusp longitudes per chart
- `aspects` - Detected aspects per chart
- `numerology_profiles` - Stored numerology calculations per user
- `card_readings` - Birth cards and spreads

---

## UI/UX Guidelines

### Cosmic Theme (consistent with QMU branding)
```css
--cosmic-void: #0a0a0f;
--deep-space: #1a1a2e;
--midnight-blue: #16213e;
--royal-blue: #0f3460;
--cosmic-pink: #e94560;
--stardust: #f8f9fa;
```

### Component Patterns
- Expandable accordion panels for interpretations
- Tabbed interface for switching between modules (Astrology | Numerology | Cards)
- Database/people selector for storing multiple profiles
- Date pickers for daily calculations
- SVG-based visualizations (chart wheels, grids, card spreads)

---

## Key Calculations Reference

### Numerology Formulas

**Life Path**: Reduce birthdate digits → `1990-06-15` → `1+9+9+0+0+6+1+5 = 31` → `3+1 = 4`

**Expression**: Full name using Pythagorean values (A=1, B=2... I=9, J=1...)

**Heart's Desire**: Vowels only (A, E, I, O, U) from full name

**Personality**: Consonants only from full name

**Birthday**: Day of birth reduced (15 → 1+5 = 6)

**Attitude**: Month + Day reduced

**Personal Year**: Birth Month + Birth Day + Current Year, reduced

**Pinnacles**:
- 1st: Month + Day (ends at age 36 - Life Path)
- 2nd: Day + Year (9 years)
- 3rd: 1st + 2nd Pinnacle (9 years)
- 4th: Month + Year (rest of life)

### Pythagorean Grid
```
1 2 3
4 5 6
7 8 9
```
Plot birthdate digits. Detect arrows (rows/columns/diagonals that are full or empty).

### Card System
- 52-card deck mapped to days of year via Grand Solar Spread
- Each birthday has a Birth Card
- Zodiac sign → Ruling Planet → Planetary Ruling Card
- Yearly spread: 7 rows (planets) × 7 columns

---

## API Endpoints (planned)

```
# Auth
POST   /api/register
POST   /api/login
POST   /api/logout

# Charts (Astrology)
GET    /api/charts
POST   /api/charts
GET    /api/charts/{id}
DELETE /api/charts/{id}
GET    /api/charts/{id}/svg
GET    /api/charts/{id}/transits

# Numerology
POST   /api/numerology/calculate
GET    /api/numerology/profiles
GET    /api/numerology/daily

# Cards
POST   /api/cards/birth-card
POST   /api/cards/yearly-spread
```

---

## Commands for Development

```bash
# Setup
composer setup
npm install

# Development
composer dev          # Runs server, queue, logs, vite concurrently

# Testing
composer test         # Full suite
composer test:unit    # Just tests
composer test:types   # PHPStan

# Linting
composer lint         # Auto-fix
composer test:lint    # Check only
```

---

## Migration Path from quantum-astrology

1. **Phase 1**: Laravel project setup, auth, database migrations
2. **Phase 2**: Port Swiss Ephemeris service, chart calculations
3. **Phase 3**: Build Numerology module (simpler, faster wins)
4. **Phase 4**: Build Cards module
5. **Phase 5**: React frontend with chart wheel, grids, spreads
6. **Phase 6**: Testing, polish, deploy

---

## Reference Documents

- `/docs/Quantum-Astrology-Laravel-Architecture.docx` - Full technical specification
- Original repo: https://github.com/meistro57/quantum-astrology

---

## Notes for AI Assistants

- Mark has 30+ years as a steel fabricator/detailer and is also building SteelFlow MRP in Laravel
- He runs Quantum Minds United (consciousness exploration platform)
- Prefer clean, type-safe code with PHP 8.4+ features
- Use `readonly` classes for DTOs
- Use enums instead of magic strings
- Keep controllers thin, business logic in Actions/Services
- Match the cosmic dark theme aesthetic
- Mark knows Laravel well — don't over-explain basics

---

*Last updated: January 2026*

> **This file provides context for AI assistants working on this project.**

---

## Project Overview

**Quantum Astrology PLUS** is a comprehensive metaphysical toolkit combining Astrology, Numerology, and Card Systems into a unified Laravel application. It's part of the [Quantum Minds United](https://quantummindsunited.com) ecosystem.

### Origin

This project evolved from [quantum-astrology](https://github.com/meistro57/quantum-astrology) (vanilla PHP) and is being rebuilt in Laravel 12 with a modular architecture to support multiple divination systems.

### Owner

- **Mark Jasinski** — Steel fabricator with 30+ years experience, consciousness explorer, creator of Eli GPT and Awakening Mind GPT
- GitHub: [@meistro57](https://github.com/meistro57)
- Website: [quantummindsunited.com](https://quantummindsunited.com)

---

## Tech Stack

| Layer | Technology |
|-------|------------|
| Backend | Laravel 12, PHP 8.4+ |
| Frontend | React 19, TypeScript, Inertia.js |
| Styling | Tailwind CSS (cosmic dark theme) |
| Database | MySQL 8+ or SQLite |
| Calculations | Swiss Ephemeris (swetest CLI) |
| Testing | Pest PHP (target 100% coverage) |
| Code Quality | PHPStan (level 9), Pint, Rector, ESLint, Prettier |

---

## Architecture Principles

1. **Strict Typing** — All PHP code uses `declare(strict_types=1)` and full type hints
2. **Immutability** — Use `readonly` classes, `CarbonImmutable`, immutable DTOs
3. **Single Responsibility** — Action classes for discrete operations
4. **Domain-Driven** — Modules for each divination system
5. **Type-Safe Enums** — PHP 8.1+ enums for all constants (planets, signs, aspects, etc.)
6. **Fail-Fast** — Errors caught at compile-time via PHPStan, not runtime

---

## Module Structure

```
app/Modules/
├── Astrology/          # Swiss Ephemeris integration, charts, transits
├── Numerology/         # Life path, expression, pythagorean grid
└── Cards/              # Birth cards, spreads, solar quadration
```

Each module should be self-contained with its own:
- Services (calculation logic)
- Actions (user operations)
- DTOs (data transfer)
- Controllers
- Requests
- Resources

Shared code goes in `app/Services/`, `app/Support/`, or the main `app/` directories.

---

## Key Features to Implement

### Astrology Module (Port from quantum-astrology)
- [ ] Swiss Ephemeris service wrapper with caching
- [ ] Natal chart generation
- [ ] Planet positions with retrograde detection
- [ ] House cusps (Placidus, Koch, Equal, Whole Sign, etc.)
- [ ] Aspect calculations with configurable orbs
- [ ] SVG chart wheel rendering (React component)
- [ ] Transit analysis
- [ ] Synastry and composite charts

### Numerology Module (New)
- [ ] Core numbers: Life Path, Expression, Heart's Desire, Personality, Birthday
- [ ] Pythagorean Grid with Arrows detection
- [ ] Pinnacles & Challenges
- [ ] Personal Year/Month/Day cycles
- [ ] Karmic Debt and Karmic Lessons
- [ ] Name analysis with vowel/consonant breakdown
- [ ] Master numbers (11, 22, 33) handling

### Cards Module (New)
- [ ] Birth Card from birthday
- [ ] Planetary Ruling Card
- [ ] 7×7 Solar Quadration spreads
- [ ] Planetary period cards
- [ ] Year-long influence cards
- [ ] Card meanings and interpretations

---

## Database Schema Overview

### Core Tables
- `users` — Authentication, preferences, subscription tier
- `profiles` — Birth data for numerology/astrology (one per user, or many for "people database")

### Astrology Tables
- `charts` — Chart metadata (type, datetime, location, settings)
- `planet_positions` — Calculated positions for each chart
- `house_cusps` — House cusp positions
- `aspects` — Calculated aspects between planets

### Numerology Tables
- `numerology_readings` — Stored calculations for a profile
- `numerology_daily` — Personal day/month/year numbers (cached)

### Cards Tables
- `card_readings` — Birth card and spread data
- `card_spreads` — Yearly quadration spreads

---

## API Design

RESTful JSON:API with Laravel Sanctum authentication.

```
GET    /api/charts              # List user's charts
POST   /api/charts              # Create new chart
GET    /api/charts/{id}         # Get chart with positions/aspects
DELETE /api/charts/{id}         # Delete chart
GET    /api/charts/{id}/svg     # Get SVG wheel
GET    /api/charts/{id}/transits # Get current transits

GET    /api/numerology/profile  # Get numerology for user's profile
POST   /api/numerology/calculate # Calculate for arbitrary data
GET    /api/numerology/daily    # Today's personal numbers

GET    /api/cards/birth-card    # Get birth card for profile
GET    /api/cards/yearly-spread # Get solar quadration for year
```

---

## UI/UX Guidelines

### Cosmic Theme Colors
```css
--cosmic-void: #0a0a0f;      /* Deepest background */
--deep-space: #1a1a2e;       /* Primary background */
--midnight-blue: #16213e;    /* Secondary background */
--royal-blue: #0f3460;       /* Accent background */
--cosmic-pink: #e94560;      /* Primary accent */
--stardust: #f8f9fa;         /* Light text */
--nebula-purple: #7c3aed;    /* Secondary accent */
```

### Design Patterns
- Dark mode by default (space aesthetic)
- Accordion panels for detailed interpretations
- Expandable sections (click number → show meaning)
- Responsive SVG visualizations
- Subtle animations (stars, gradients)

---

## Testing Strategy

- **Unit Tests**: Services, calculations, enums
- **Feature Tests**: API endpoints, authentication flows
- **Browser Tests**: Pest + Playwright for critical UI paths
- **Target**: 100% code coverage

```bash
composer test           # Full suite
composer test:unit      # Just unit tests
composer test:types     # PHPStan analysis
```

---

## Key Files Reference

| File | Purpose |
|------|---------|
| `config/astrology.php` | Swiss Ephemeris paths, orbs, defaults |
| `config/numerology.php` | Pythagorean values, arrows, meanings |
| `config/cards.php` | Suit meanings, planetary periods |
| `app/Enums/*.php` | Type-safe constants |
| `app/Services/SwissEphemerisService.php` | Ephemeris calculations |
| `app/Modules/Numerology/Services/NumerologyCalculator.php` | Number calculations |
| `app/Services/CardSpreadEngine.php` | Card calculations |
| `docs/architecture.docx` | Full technical specification |

---

## Commands

```bash
composer setup          # Initial project setup
composer dev            # Start all dev servers
composer lint           # Fix code style
composer test           # Run full test suite
```

---

## Migration from quantum-astrology

The original project has:
- Swiss Ephemeris CLI integration (preserve this)
- SVG chart generation (port to React)
- User auth (replace with Laravel Breeze)
- MySQL schema (convert to Laravel migrations)

Key classes to port:
- `classes/SwissEphemeris.php` → `app/Services/SwissEphemerisService.php`
- `classes/ChartCalculator.php` → `app/Actions/Charts/CreateChartAction.php`
- `classes/AspectCalculator.php` → `app/Actions/Charts/CalculateAspectsAction.php`
- `api/*.php` → `app/Http/Controllers/Api/*`

---

## Notes for AI Assistants

1. **Always use strict types** — `declare(strict_types=1);` at top of every PHP file
2. **Prefer enums over strings** — Use `Planet::Sun` not `'sun'`
3. **Use DTOs** — Don't pass arrays, create typed data objects
4. **Action classes** — One public `execute()` method per action
5. **Cache ephemeris calls** — Swiss Ephemeris is expensive, cache for 30 days
6. **Immutable dates** — Always use `CarbonImmutable`
7. **Final classes** — Mark classes as `final` unless designed for extension
8. **Readonly properties** — Use `readonly` for DTOs and value objects

---

## Related Projects

- [quantum-astrology](https://github.com/meistro57/quantum-astrology) — Original vanilla PHP version
- [SteelFlow MRP](private) — Mark's Laravel steel fabrication software
- [Quantum Minds United](https://quantummindsunited.com) — Parent platform

---

## Questions?

If you're an AI assistant and need clarification, ask Mark! He's building this to bridge consciousness exploration with modern tech.
