<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Astrology;

use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class NatalChartApiTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateNatalChart(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/astrology/charts', [
            'datetime' => CarbonImmutable::create(1990, 6, 15, 12, 0, 0, 'UTC')->toIso8601String(),
            'latitude' => 40.7128,
            'longitude' => -74.0060,
        ]);

        $response->assertOk();
        $response->assertJsonPath('sun.sign', 'Gemini');
        $response->assertJsonPath('ascendant.sign', 'Capricorn');
        $response->assertJsonStructure([
            'datetime',
            'location' => ['latitude', 'longitude'],
            'sun' => ['longitude', 'sign'],
            'ascendant' => ['longitude', 'sign'],
            'planets',
        ]);
    }
}
