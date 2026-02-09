<?php

declare(strict_types=1);

namespace App\Modules\Numerology\Http\Resources;

use App\Modules\Numerology\DTOs\NumerologyProfileData;
use Illuminate\Http\Resources\Json\JsonResource;

final class NumerologyProfileResource extends JsonResource
{
    /** @var NumerologyProfileData */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        $data = $this->resource;

        return [
            'id' => $data->userId,
            'full_name' => $data->fullName,
            'birth_date' => $data->birthDate->toIso8601String(),
            
            'core_numbers' => [
                'life_path' => $data->lifePath,
                'expression' => $data->expression,
                'hearts_desire' => $data->heartsDesire,
                'personality' => $data->personality,
                'birthday' => $data->birthday,
            ],
            
            'pinnacles' => [
                'first' => $data->firstPinnacle,
                'second' => $data->secondPinnacle,
                'third' => $data->thirdPinnacle,
                'fourth' => $data->fourthPinnacle,
            ],
            
            'grid' => [
                'numbers' => $data->gridNumbers,
                'arrows' => $data->gridArrows,
                'interpretations' => $data->gridInterpretations,
            ],
            
            'advanced' => [
                'has_master_numbers' => $data->hasMasterNumbers,
                'grid_interpretations' => $data->getGridInterpretations(),
            ]
        ];
    }

    /**
     * Create a new resource instance from DTO
     */
    public static function fromDto(NumerologyProfileData $data): self
    {
        return new self($data);
    }
}
