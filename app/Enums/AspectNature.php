<?php

declare(strict_types=1);

namespace App\Enums;

enum AspectNature: string
{
    case Harmonious = 'harmonious';
    case Challenging = 'challenging';
    case Neutral = 'neutral';
    case Minor = 'minor';

    public function color(): string
    {
        return match ($this) {
            self::Harmonious => '#22c55e', // green
            self::Challenging => '#ef4444', // red
            self::Neutral => '#3b82f6', // blue
            self::Minor => '#9ca3af', // gray
        };
    }
}
