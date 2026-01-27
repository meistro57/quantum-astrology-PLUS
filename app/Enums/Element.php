<?php

declare(strict_types=1);

namespace App\Enums;

enum Element: string
{
    case Fire = 'fire';
    case Earth = 'earth';
    case Air = 'air';
    case Water = 'water';

    public function symbol(): string
    {
        return match ($this) {
            self::Fire => '🜂',
            self::Earth => '🜃',
            self::Air => '🜁',
            self::Water => '🜄',
        };
    }

    public function keywords(): array
    {
        return match ($this) {
            self::Fire => ['action', 'energy', 'enthusiasm', 'inspiration'],
            self::Earth => ['stability', 'practicality', 'material', 'grounded'],
            self::Air => ['intellect', 'communication', 'ideas', 'social'],
            self::Water => ['emotion', 'intuition', 'feeling', 'nurturing'],
        };
    }
}
