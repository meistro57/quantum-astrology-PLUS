# ✨ Quantum Astrology PLUS

[![Build Status](https://github.com/meistro57/quantum-astrology-PLUS/actions/workflows/tests.yml/badge.svg)](https://github.com/meistro57/quantum-astrology-PLUS/actions)
[![License](https://img.shields.io/github/license/meistro57/quantum-astrology-PLUS)](LICENSE)

**A comprehensive metaphysical toolkit featuring Astrology, Numerology, and Card Systems**

Powered by [Quantum Minds United](https://quantummindsunited.com)

![Quantum Astrology PLUS Banner](art/banner.png)

---

## 🌟 Overview

Quantum Astrology PLUS is an open-source exploration at the crossroads of ancient wisdom and modern computation. This project combines multiple divination systems into a unified platform:

- **🔮 Astrology** — Swiss Ephemeris-powered natal charts, transits, and aspects
- **🔢 Numerology** — Life Path, Expression, Heart's Desire, Pythagorean Grid, Pinnacles
- **🃏 Card Systems** — Birth Cards, Planetary Spreads, Solar Quadration

---

## ✨ Features

### Astrology Module
- Natal chart generation with SVG wheel visualization
- Planetary positions with retrograde detection
- House cusps (Placidus, Koch, Equal, Whole Sign, etc.)
- Aspect calculations with configurable orbs
- Transit analysis and real-time planetary movement
- Synastry and composite charts

### Numerology Module
- **Core Numbers**: Life Path, Expression, Heart's Desire, Personality, Birthday
- **Pythagorean Grid**: Arrows of Pythagoras analysis
- **Pinnacles & Challenges**: Life period breakdowns
- **Daily Numerology**: Personal Day, Month, Year numbers
- **Karmic Numbers**: Debt and lessons detection
- **Name Analysis**: Full breakdown with vowel/consonant mapping

### Cards Module
- Birth Card determination from birthday
- Planetary Ruling Card
- 7×7 Solar Quadration spreads
- Year-long influence cards
- Planetary period interpretations

---

## 🛠 Technology Stack

- **Backend**: Laravel 12 with PHP 8.4+
- **Frontend**: React 19 + TypeScript + Inertia.js
- **Styling**: Tailwind CSS with cosmic theme
- **Database**: MySQL 8+ / SQLite
- **Calculations**: Swiss Ephemeris (swetest CLI)
- **Testing**: Pest PHP with 100% coverage
- **CI/CD**: GitHub Actions

---

## 🚀 Getting Started

### Prerequisites

- PHP 8.4 or higher
- Composer 2.x
- Node.js 20+ and npm
- MySQL 8+ or SQLite
- Swiss Ephemeris (for astrology module)

### Installation

```bash
# Clone the repository
git clone https://github.com/meistro57/quantum-astrology-PLUS.git
cd quantum-astrology-PLUS

# Install dependencies and setup
composer setup
npm install

# Start development server
composer dev
```

### Environment Configuration

Copy `.env.example` to `.env` and configure:

```env
APP_NAME="Quantum Astrology PLUS"
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
# Or for MySQL:
# DB_CONNECTION=mysql
# DB_DATABASE=quantum_astrology_plus

# Swiss Ephemeris paths (for astrology module)
SWETEST_PATH=/usr/local/bin/swetest
EPHEMERIS_PATH=/path/to/ephemeris/files
```

### Verify Installation

```bash
composer test
```

---

## 📁 Project Structure

```
quantum-astrology-PLUS/
├── app/
│   ├── Modules/
│   │   ├── Astrology/          # Astrology calculations & charts
│   │   ├── Numerology/         # Numerology calculations
│   │   └── Cards/              # Card spread systems
│   ├── Actions/                # Single-responsibility actions
│   ├── DTOs/                   # Data Transfer Objects
│   ├── Enums/                  # PHP 8.1+ enums
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Requests/
│   │   └── Resources/
│   ├── Models/
│   └── Services/
├── config/
│   ├── astrology.php
│   ├── numerology.php
│   └── cards.php
├── database/
│   ├── migrations/
│   ├── factories/
│   └── seeders/
├── resources/
│   ├── js/
│   │   ├── Components/
│   │   │   ├── Astrology/      # Chart wheels, aspect tables
│   │   │   ├── Numerology/     # Grids, number displays
│   │   │   ├── Cards/          # Card spreads, layouts
│   │   │   └── Shared/         # Cosmic UI components
│   │   ├── Pages/
│   │   └── types/
│   └── css/
├── routes/
├── tests/
│   ├── Feature/
│   └── Unit/
└── docs/
    └── architecture.docx       # Full technical specification
```

---

## 🧮 Numerology Calculations

### Life Path Number
```php
// Reduce birth date to single digit (or master number)
$birthdate = '1990-06-15';
// 1+9+9+0 + 0+6 + 1+5 = 31 → 3+1 = 4
// Life Path: 4
```

### Expression Number
```php
// Full name converted using Pythagorean system
// A=1, B=2, C=3... I=9, J=1, K=2...
$name = "Mark James Jasinski";
// M(4) + A(1) + R(9) + K(2) = 16 → 7
// ... continue for full name
```

### Pythagorean Grid
```
1 2 3
4 5 6
7 8 9
```
Arrows detected based on missing/present numbers.

---

## 🃏 Card System

Based on the Book of Destiny / Cards of Illumination system:

- **Birth Card**: Derived from birthday position in the Grand Solar Spread
- **Planetary Ruling Card**: Based on ruling planet of birth sign
- **Solar Quadration**: 7×7 yearly spread with planetary periods

---

## 📚 Available Commands

### Development
```bash
composer dev          # Start all dev servers
npm run dev           # Vite dev server only
```

### Code Quality
```bash
composer lint         # Fix code style (Rector, Pint, Prettier)
composer test:lint    # Check code style (CI mode)
composer test:types   # PHPStan analysis
composer test:unit    # Run tests with coverage
composer test         # Full test suite
```

---

## 🎨 Cosmic UI Theme

The interface uses a deep space aesthetic:

```css
:root {
  --cosmic-void: #0a0a0f;
  --deep-space: #1a1a2e;
  --midnight-blue: #16213e;
  --royal-blue: #0f3460;
  --cosmic-pink: #e94560;
  --stardust: #f8f9fa;
}
```

---

## 🤝 Contributing

Contributions are welcome! Please read our contributing guidelines before submitting PRs.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

---

## 📄 License

This project is licensed under the GPL-3.0 License - see the [LICENSE](LICENSE) file for details.

---

## 🙏 Acknowledgments

- [Swiss Ephemeris](https://www.astro.com/swisseph/) for astronomical calculations
- The Laravel and React communities
- Ancient wisdom keepers who preserved these systems

---

<p align="center">
  <strong>Built with ❤️ by <a href="https://quantummindsunited.com">Quantum Minds United</a></strong>
</p>
