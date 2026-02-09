<?php

declare(strict_types=1);

namespace App\Modules\Numerology\Actions;

use App\Modules\Numerology\DTOs\NumerologyProfileData;
use App\Models\User;
use App\Modules\Numerology\Services\NumerologyCalculator;
use App\Modules\Numerology\Services\PythagoreanGridCalculator;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;

final class CreateNumerologyProfileAction
{
    public function __construct(
        private readonly NumerologyCalculator $numerologyCalculator,
        private readonly PythagoreanGridCalculator $gridCalculator
    ) {}

    /**
     * Create a new numerology profile for a user
     */
    public function execute(
        User $user, 
        string $fullName, 
        CarbonImmutable $birthDate
    ): NumerologyProfileData {
        return DB::transaction(function () use ($user, $fullName, $birthDate) {
            // Calculate core numbers
            $lifePath = $this->numerologyCalculator->calculateLifePath($birthDate);
            $expression = $this->numerologyCalculator->calculateExpression($fullName);
            $heartsDesire = $this->numerologyCalculator->calculateHeartsDesire($fullName);
            $personality = $this->numerologyCalculator->calculatePersonality($fullName);
            $birthday = $this->numerologyCalculator->calculateBirthday($birthDate);

            // Calculate pinnacles and challenges
            $pinnacles = $this->numerologyCalculator->calculatePinnacles($birthDate);

            // Calculate Pythagorean Grid
            $gridData = $this->gridCalculator->calculateGrid($birthDate->format('Y-m-d'));
            $gridInterpretations = $this->gridCalculator->interpretGrid($gridData);

            // Determine if master numbers are present
            $hasMasterNumbers = array_reduce([
                $lifePath, $expression, $heartsDesire, 
                $personality, $birthday
            ], function ($carry, $number) {
                return $carry || $this->numerologyCalculator->isMasterNumber($number);
            }, false);

            // Create DTO with all calculated data
            return new NumerologyProfileData(
                userId: $user->id,
                fullName: $fullName,
                birthDate: $birthDate,
                lifePath: $lifePath,
                expression: $expression,
                heartsDesire: $heartsDesire,
                personality: $personality,
                birthday: $birthday,
                firstPinnacle: $pinnacles['first'] ?? null,
                secondPinnacle: $pinnacles['second'] ?? null,
                thirdPinnacle: $pinnacles['third'] ?? null,
                fourthPinnacle: $pinnacles['fourth'] ?? null,
                gridNumbers: $gridData['grid_numbers'],
                gridArrows: $gridData['grid_arrows'],
                gridInterpretations: $gridInterpretations,
                hasMasterNumbers: $hasMasterNumbers
            );
        });
    }
}
