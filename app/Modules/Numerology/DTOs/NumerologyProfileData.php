<?php

declare(strict_types=1);

namespace App\Modules\Numerology\DTOs;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Data;

final class NumerologyProfileData extends Data
{
    public function __construct(
        public readonly int $userId,
        
        #[Max(255)]
        public readonly string $fullName,
        
        #[Date]
        public readonly CarbonImmutable $birthDate,
        
        #[Min(1), Max(33)]
        public readonly int $lifePath,
        
        #[Min(1), Max(33)]
        public readonly int $expression,
        
        #[Min(1), Max(33)]
        public readonly int $heartsDesire,
        
        #[Min(1), Max(33)]
        public readonly int $personality,
        
        #[Min(1), Max(33)]
        public readonly int $birthday,
        
        #[Min(1), Max(33)]
        public readonly ?int $firstPinnacle = null,
        
        #[Min(1), Max(33)]
        public readonly ?int $secondPinnacle = null,
        
        #[Min(1), Max(33)]
        public readonly ?int $thirdPinnacle = null,
        
        #[Min(1), Max(33)]
        public readonly ?int $fourthPinnacle = null,
        
        /** @var array<int> */
        public readonly array $gridNumbers = [],
        
        /** @var array<string> */
        public readonly array $gridArrows = [],
        
        /** @var array<string, string> */
        public readonly array $gridInterpretations = [],
        
        public readonly bool $hasMasterNumbers = false
    ) {}

    /**
     * Validate if this profile has master numbers
     */
    public function containsMasterNumbers(): bool
    {
        return $this->hasMasterNumbers;
    }

    /**
     * Get detailed grid interpretations
     * 
     * @return array<string, string>
     */
    public function getGridInterpretations(): array
    {
        return $this->gridInterpretations;
    }
}
