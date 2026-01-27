<?php

declare(strict_types=1);

namespace App\Enums;

enum Planet: string
{
    case Sun = 'sun';
    case Moon = 'moon';
    case Mercury = 'mercury';
    case Venus = 'venus';
    case Mars = 'mars';
    case Jupiter = 'jupiter';
    case Saturn = 'saturn';
    case Uranus = 'uranus';
    case Neptune = 'neptune';
    case Pluto = 'pluto';
    case NorthNode = 'north_node';
    case SouthNode = 'south_node';
    case Chiron = 'chiron';
    case Ascendant = 'ascendant';
    case Midheaven = 'midheaven';

    public function label(): string
    {
        return match ($this) {
            self::Sun => '☉ Sun',
            self::Moon => '☽ Moon',
            self::Mercury => '☿ Mercury',
            self::Venus => '♀ Venus',
            self::Mars => '♂ Mars',
            self::Jupiter => '♃ Jupiter',
            self::Saturn => '♄ Saturn',
            self::Uranus => '♅ Uranus',
            self::Neptune => '♆ Neptune',
            self::Pluto => '♇ Pluto',
            self::NorthNode => '☊ North Node',
            self::SouthNode => '☋ South Node',
            self::Chiron => '⚷ Chiron',
            self::Ascendant => 'ASC',
            self::Midheaven => 'MC',
        };
    }

    public function symbol(): string
    {
        return match ($this) {
            self::Sun => '☉',
            self::Moon => '☽',
            self::Mercury => '☿',
            self::Venus => '♀',
            self::Mars => '♂',
            self::Jupiter => '♃',
            self::Saturn => '♄',
            self::Uranus => '♅',
            self::Neptune => '♆',
            self::Pluto => '♇',
            self::NorthNode => '☊',
            self::SouthNode => '☋',
            self::Chiron => '⚷',
            self::Ascendant => 'AC',
            self::Midheaven => 'MC',
        };
    }

    public function sweCode(): int
    {
        return match ($this) {
            self::Sun => 0,
            self::Moon => 1,
            self::Mercury => 2,
            self::Venus => 3,
            self::Mars => 4,
            self::Jupiter => 5,
            self::Saturn => 6,
            self::Uranus => 7,
            self::Neptune => 8,
            self::Pluto => 9,
            self::NorthNode => 10,
            self::SouthNode => 11,
            self::Chiron => 15,
            default => -1,
        };
    }

    public function isLuminary(): bool
    {
        return in_array($this, [self::Sun, self::Moon], true);
    }

    public function isPersonal(): bool
    {
        return in_array($this, [self::Sun, self::Moon, self::Mercury, self::Venus, self::Mars], true);
    }

    public function isSocial(): bool
    {
        return in_array($this, [self::Jupiter, self::Saturn], true);
    }

    public function isTranspersonal(): bool
    {
        return in_array($this, [self::Uranus, self::Neptune, self::Pluto], true);
    }

    public function isAngle(): bool
    {
        return in_array($this, [self::Ascendant, self::Midheaven], true);
    }
}
