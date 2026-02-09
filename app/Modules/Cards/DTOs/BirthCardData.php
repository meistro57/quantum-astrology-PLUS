<?php

declare(strict_types=1);

namespace App\Modules\Cards\DTOs;

use Spatie\LaravelData\Data;

final class BirthCardData extends Data
{
    public function __construct(
        public readonly string $birthCard,
        public readonly ?string $rulingCard = null,
        public readonly ?string $planetaryCard = null
    ) {}
}
