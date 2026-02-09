<?php

declare(strict_types=1);

namespace App\Modules\Astrology\Http\Resources;

use App\Modules\Astrology\DTOs\NatalChartData;
use Illuminate\Http\Resources\Json\JsonResource;

final class NatalChartResource extends JsonResource
{
    /** @var NatalChartData */
    public $resource;

    /**
     * @param \Illuminate\Http\Request $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        $data = $this->resource;

        return [
            'datetime' => $data->dateTime->toIso8601String(),
            'location' => [
                'latitude' => $data->latitude,
                'longitude' => $data->longitude,
            ],
            'sun' => [
                'longitude' => $data->sunLongitude,
                'sign' => $data->sunSign->name,
            ],
            'ascendant' => [
                'longitude' => $data->ascendantLongitude,
                'sign' => $data->ascendantSign->name,
            ],
            'planets' => $data->planetLongitudes,
        ];
    }

    public static function fromDto(NatalChartData $data): self
    {
        return new self($data);
    }
}
