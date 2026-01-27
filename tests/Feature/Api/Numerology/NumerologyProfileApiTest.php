<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Numerology;

use App\Models\NumerologyProfile;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class NumerologyProfileApiTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private string $baseUrl = '/api/numerology/profiles';

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function testCreateNumerologyProfile(): void
    {
        $profileData = [
            'full_name' => 'John Albert Doe',
            'birth_date' => '1990-06-15'
        ];

        $response = $this->postJson($this->baseUrl, $profileData);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'full_name',
                    'birth_date',
                    'core_numbers' => [
                        'life_path',
                        'expression',
                        'hearts_desire',
                        'personality',
                        'birthday'
                    ],
                    'pinnacles',
                    'grid',
                    'advanced'
                ]
            ])
            ->assertJson([
                'data' => [
                    'full_name' => 'John Albert Doe',
                    'birth_date' => '1990-06-15T00:00:00+00:00'
                ]
            ]);

        $this->assertDatabaseHas('numerology_profiles', [
            'user_id' => $this->user->id,
            'full_name' => 'John Albert Doe',
        ]);
    }

    public function testCreateNumerologyProfileValidationFails(): void
    {
        $invalidCases = [
            ['full_name' => '', 'birth_date' => '1990-06-15'],
            ['full_name' => 'John Doe', 'birth_date' => 'not-a-date'],
            ['full_name' => 'John123 Doe', 'birth_date' => '1990-06-15'],
            ['full_name' => 'John Doe', 'birth_date' => '2025-01-01']
        ];

        foreach ($invalidCases as $case) {
            $response = $this->postJson($this->baseUrl, $case);
            $response->assertStatus(422);
        }
    }

    public function testListNumerologyProfiles(): void
    {
        // Create a few profiles for the user
        NumerologyProfile::factory()->count(3)->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->getJson($this->baseUrl);

        $response
            ->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function testShowNumerologyProfile(): void
    {
        $profile = NumerologyProfile::factory()->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->getJson("{$this->baseUrl}/{$profile->id}");

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'full_name',
                    'birth_date',
                    'core_numbers',
                    'pinnacles',
                    'grid',
                    'advanced'
                ]
            ]);
    }

    public function testDeleteNumerologyProfile(): void
    {
        $profile = NumerologyProfile::factory()->create([
            'user_id' => $this->user->id
        ]);

        $response = $this->deleteJson("{$this->baseUrl}/{$profile->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('numerology_profiles', [
            'id' => $profile->id
        ]);
    }

    public function testPersonalCyclesCalculation(): void
    {
        $profile = NumerologyProfile::factory()->create([
            'user_id' => $this->user->id,
            'birth_date' => '1990-06-15'
        ]);

        $targetDate = '2026-01-27';
        $response = $this->getJson("{$this->baseUrl}/{$profile->id}/cycles/{$targetDate}");

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'personal_cycles' => [
                    'personal_year',
                    'personal_month',
                    'personal_day'
                ],
                'target_date'
            ]);
    }

    public function testUnauthorizedAccessToOtherUserProfile(): void
    {
        // Create a profile for another user
        $otherUser = User::factory()->create();
        $profile = NumerologyProfile::factory()->create([
            'user_id' => $otherUser->id
        ]);

        // Try to access the profile
        $responses = [
            $this->getJson("{$this->baseUrl}/{$profile->id}"),
            $this->deleteJson("{$this->baseUrl}/{$profile->id}"),
            $this->getJson("{$this->baseUrl}/{$profile->id}/cycles/2026-01-27")
        ];

        foreach ($responses as $response) {
            $response->assertStatus(403);
        }
    }
}