<?php

declare(strict_types=1);

namespace App\Modules\Cards\Services;

use App\Enums\ZodiacSign;
use App\Modules\Cards\DTOs\BirthCardData;
use Carbon\CarbonImmutable;

final class BirthCardCalculator
{
    /**
     * @var array<int, string>
     */
    private array $numerologyCardMap;

    public function __construct()
    {
        $this->numerologyCardMap = (array) config('modules.integration.cards.numerology_card_mapping', []);
    }

    public function calculateBirthCard(
        CarbonImmutable $birthDate,
        ?ZodiacSign $sign = null
    ): BirthCardData {
        $birthNumber = $this->calculateBirthNumber($birthDate);
        $birthCard = $this->numerologyCardMap[$birthNumber] ?? 'Unknown';

        $planetaryCard = null;
        if ($sign !== null) {
            $planet = $sign->ruler();
            $planetaryCard = $this->numerologyCardMap[$planet->value] ?? null;
        }

        return new BirthCardData(
            birthCard: $birthCard,
            rulingCard: null,
            planetaryCard: $planetaryCard
        );
    }

    private function calculateBirthNumber(CarbonImmutable $birthDate): int
    {
        $sum = array_sum(str_split($birthDate->format('Ymd')));

        while ($sum > 9 && $sum !== 11 && $sum !== 22 && $sum !== 33) {
            $sum = array_sum(str_split((string) $sum));
        }

        return $sum;
    }
}
