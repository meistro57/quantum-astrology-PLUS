<?php

declare(strict_types=1);

namespace App\Enums;

enum ZodiacSign: int
{
    case Aries = 1;
    case Taurus = 2;
    case Gemini = 3;
    case Cancer = 4;
    case Leo = 5;
    case Virgo = 6;
    case Libra = 7;
    case Scorpio = 8;
    case Sagittarius = 9;
    case Capricorn = 10;
    case Aquarius = 11;
    case Pisces = 12;

    public function symbol(): string
    {
        return match ($this) {
            self::Aries => '♈',
            self::Taurus => '♉',
            self::Gemini => '♊',
            self::Cancer => '♋',
            self::Leo => '♌',
            self::Virgo => '♍',
            self::Libra => '♎',
            self::Scorpio => '♏',
            self::Sagittarius => '♐',
            self::Capricorn => '♑',
            self::Aquarius => '♒',
            self::Pisces => '♓',
        };
    }

    public function element(): Element
    {
        return match ($this) {
            self::Aries, self::Leo, self::Sagittarius => Element::Fire,
            self::Taurus, self::Virgo, self::Capricorn => Element::Earth,
            self::Gemini, self::Libra, self::Aquarius => Element::Air,
            self::Cancer, self::Scorpio, self::Pisces => Element::Water,
        };
    }

    public function modality(): Modality
    {
        return match ($this) {
            self::Aries, self::Cancer, self::Libra, self::Capricorn => Modality::Cardinal,
            self::Taurus, self::Leo, self::Scorpio, self::Aquarius => Modality::Fixed,
            self::Gemini, self::Virgo, self::Sagittarius, self::Pisces => Modality::Mutable,
        };
    }

    public function ruler(): Planet
    {
        return match ($this) {
            self::Aries => Planet::Mars,
            self::Taurus => Planet::Venus,
            self::Gemini => Planet::Mercury,
            self::Cancer => Planet::Moon,
            self::Leo => Planet::Sun,
            self::Virgo => Planet::Mercury,
            self::Libra => Planet::Venus,
            self::Scorpio => Planet::Pluto,
            self::Sagittarius => Planet::Jupiter,
            self::Capricorn => Planet::Saturn,
            self::Aquarius => Planet::Uranus,
            self::Pisces => Planet::Neptune,
        };
    }

    public function startDegree(): float
    {
        return ($this->value - 1) * 30.0;
    }

    public function endDegree(): float
    {
        return $this->value * 30.0;
    }

    public static function fromLongitude(float $longitude): self
    {
        $normalized = fmod($longitude, 360);
        if ($normalized < 0) {
            $normalized += 360;
        }

        return self::from((int) floor($normalized / 30) + 1);
    }

    public static function fromDate(\DateTimeInterface $date): self
    {
        $month = (int) $date->format('n');
        $day = (int) $date->format('j');

        return match (true) {
            ($month === 3 && $day >= 21) || ($month === 4 && $day <= 19) => self::Aries,
            ($month === 4 && $day >= 20) || ($month === 5 && $day <= 20) => self::Taurus,
            ($month === 5 && $day >= 21) || ($month === 6 && $day <= 20) => self::Gemini,
            ($month === 6 && $day >= 21) || ($month === 7 && $day <= 22) => self::Cancer,
            ($month === 7 && $day >= 23) || ($month === 8 && $day <= 22) => self::Leo,
            ($month === 8 && $day >= 23) || ($month === 9 && $day <= 22) => self::Virgo,
            ($month === 9 && $day >= 23) || ($month === 10 && $day <= 22) => self::Libra,
            ($month === 10 && $day >= 23) || ($month === 11 && $day <= 21) => self::Scorpio,
            ($month === 11 && $day >= 22) || ($month === 12 && $day <= 21) => self::Sagittarius,
            ($month === 12 && $day >= 22) || ($month === 1 && $day <= 19) => self::Capricorn,
            ($month === 1 && $day >= 20) || ($month === 2 && $day <= 18) => self::Aquarius,
            default => self::Pisces,
        };
    }
}
