<?php

declare(strict_types=1);

namespace App\Enums;

enum AspectType: string
{
    case Conjunction = 'conjunction';
    case Opposition = 'opposition';
    case Trine = 'trine';
    case Square = 'square';
    case Sextile = 'sextile';
    case Quincunx = 'quincunx';
    case Semisextile = 'semisextile';
    case Semisquare = 'semisquare';
    case Sesquisquare = 'sesquisquare';
    case Quintile = 'quintile';
    case Biquintile = 'biquintile';

    public function degrees(): float
    {
        return match ($this) {
            self::Conjunction => 0.0,
            self::Semisextile => 30.0,
            self::Semisquare => 45.0,
            self::Sextile => 60.0,
            self::Quintile => 72.0,
            self::Square => 90.0,
            self::Trine => 120.0,
            self::Sesquisquare => 135.0,
            self::Biquintile => 144.0,
            self::Quincunx => 150.0,
            self::Opposition => 180.0,
        };
    }

    public function defaultOrb(): float
    {
        return match ($this) {
            self::Conjunction, self::Opposition => 8.0,
            self::Trine, self::Square => 7.0,
            self::Sextile => 5.0,
            self::Quincunx => 3.0,
            default => 2.0,
        };
    }

    public function symbol(): string
    {
        return match ($this) {
            self::Conjunction => '☌',
            self::Opposition => '☍',
            self::Trine => '△',
            self::Square => '□',
            self::Sextile => '⚹',
            self::Quincunx => '⚻',
            self::Semisextile => '⚺',
            self::Semisquare => '∠',
            self::Sesquisquare => '⚼',
            self::Quintile => 'Q',
            self::Biquintile => 'bQ',
        };
    }

    public function nature(): AspectNature
    {
        return match ($this) {
            self::Conjunction => AspectNature::Neutral,
            self::Trine, self::Sextile => AspectNature::Harmonious,
            self::Square, self::Opposition, self::Semisquare, self::Sesquisquare => AspectNature::Challenging,
            default => AspectNature::Minor,
        };
    }

    public function isMajor(): bool
    {
        return in_array($this, [
            self::Conjunction,
            self::Opposition,
            self::Trine,
            self::Square,
            self::Sextile,
        ], true);
    }
}
