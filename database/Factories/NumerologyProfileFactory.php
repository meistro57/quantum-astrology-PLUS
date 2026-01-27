<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\NumerologyProfile;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<NumerologyProfile>
 */
final class NumerologyProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $birthDate = $this->faker->dateTimeBetween('-60 years', '-18 years');
        $fullName = $this->faker->name();

        return [
            'user_id' => User::factory(),
            'full_name' => $fullName,
            'birth_date' => $birthDate,
            
            // Core Numbers
            'life_path' => $this->faker->numberBetween(1, 9),
            'expression' => $this->faker->numberBetween(1, 9),
            'hearts_desire' => $this->faker->numberBetween(1, 9),
            'personality' => $this->faker->numberBetween(1, 9),
            'birthday' => $this->faker->numberBetween(1, 9),
            
            // Pinnacles
            'first_pinnacle' => $this->faker->numberBetween(1, 9),
            'second_pinnacle' => $this->faker->numberBetween(1, 9),
            'third_pinnacle' => $this->faker->numberBetween(1, 9),
            'fourth_pinnacle' => $this->faker->numberBetween(1, 9),
            
            // Grid and Misc
            'grid_numbers' => json_encode(array_fill(0, 9, $this->faker->numberBetween(0, 3))),
            'grid_arrows' => json_encode([
                'Top Row', 
                'Middle Column', 
                'Left Diagonal'
            ]),
            'grid_interpretations' => json_encode([
                'number_1' => 'Leadership potential',
                'number_5' => 'Adaptability',
            ]),
            'has_master_numbers' => $this->faker->boolean(20)
        ];
    }

    /**
     * Create a profile with master numbers
     */
    public function withMasterNumbers(): self
    {
        return $this->state(fn () => [
            'life_path' => 11,
            'expression' => 22,
            'has_master_numbers' => true
        ]);
    }
}