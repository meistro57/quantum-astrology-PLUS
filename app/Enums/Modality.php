<?php

declare(strict_types=1);

namespace App\Enums;

enum Modality: string
{
    case Cardinal = 'cardinal';
    case Fixed = 'fixed';
    case Mutable = 'mutable';

    public function keywords(): array
    {
        return match ($this) {
            self::Cardinal => ['initiating', 'leadership', 'action', 'starting'],
            self::Fixed => ['stabilizing', 'persistence', 'determination', 'maintaining'],
            self::Mutable => ['adapting', 'flexibility', 'change', 'transitioning'],
        };
    }
}
