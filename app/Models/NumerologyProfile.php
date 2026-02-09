<?php

declare(strict_types=1);

namespace App\Models;

use App\Modules\Numerology\DTOs\NumerologyProfileData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class NumerologyProfile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'full_name',
        'birth_date',
        'life_path',
        'expression',
        'hearts_desire',
        'personality',
        'birthday',
        'first_pinnacle',
        'second_pinnacle',
        'third_pinnacle',
        'fourth_pinnacle',
        'grid_numbers',
        'grid_arrows',
        'grid_interpretations',
        'has_master_numbers',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
        'grid_numbers' => 'array',
        'grid_arrows' => 'array',
        'grid_interpretations' => 'array',
        'has_master_numbers' => 'boolean',
    ];

    /**
     * Relationship to User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Create a new profile from DTO
     */
    public static function createFromDto(NumerologyProfileData $data): self
    {
        return self::create([
            'user_id' => $data->userId,
            'full_name' => $data->fullName,
            'birth_date' => $data->birthDate,
            'life_path' => $data->lifePath,
            'expression' => $data->expression,
            'hearts_desire' => $data->heartsDesire,
            'personality' => $data->personality,
            'birthday' => $data->birthday,
            'first_pinnacle' => $data->firstPinnacle,
            'second_pinnacle' => $data->secondPinnacle,
            'third_pinnacle' => $data->thirdPinnacle,
            'fourth_pinnacle' => $data->fourthPinnacle,
            'grid_numbers' => $data->gridNumbers,
            'grid_arrows' => $data->gridArrows,
            'grid_interpretations' => $data->gridInterpretations,
            'has_master_numbers' => $data->hasMasterNumbers,
        ]);
    }

    /**
     * Convert model to DTO
     */
    public function toDto(): NumerologyProfileData
    {
        return new NumerologyProfileData(
            userId: $this->user_id,
            fullName: $this->full_name,
            birthDate: $this->birth_date,
            lifePath: $this->life_path,
            expression: $this->expression,
            heartsDesire: $this->hearts_desire,
            personality: $this->personality,
            birthday: $this->birthday,
            firstPinnacle: $this->first_pinnacle,
            secondPinnacle: $this->second_pinnacle,
            thirdPinnacle: $this->third_pinnacle,
            fourthPinnacle: $this->fourth_pinnacle,
            gridNumbers: $this->grid_numbers,
            gridArrows: $this->grid_arrows,
            gridInterpretations: $this->grid_interpretations,
            hasMasterNumbers: $this->has_master_numbers
        );
    }
}
