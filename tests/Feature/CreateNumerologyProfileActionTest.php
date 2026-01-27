<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Actions\Numerology\CreateNumerologyProfileAction;
use App\Models\User;
use App\Services\NumerologyCalculator;
use App\Services\PythagoreanGridCalculator;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class CreateNumerologyProfileActionTest extends TestCase
{
    use RefreshDatabase;

    private CreateNumerologyProfileAction $action;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->action = new CreateNumerologyProfileAction(
            new NumerologyCalculator(),
            new PythagoreanGridCalculator()
        );
    }

    public function testCreateNumerologyProfile(): void
    {
        $fullName = 'John Albert Doe';
        $birthDate = CarbonImmutable::create(1990, 6, 15);

        $profileData = $this->action->execute($this->user, $fullName, $birthDate);

        $this->assertNotNull($profileData);
        $this->assertEquals($this->user->id, $profileData->userId);
        $this->assertEquals($fullName, $profileData->fullName);
        $this->assertEquals($birthDate, $profileData->birthDate);

        // Verify core numbers
        $this->assertIsInt($profileData->lifePath);
        $this->assertIsInt($profileData->expression);
        $this->assertIsInt($profileData->heartsDesire);
        $this->assertIsInt($profileData->personality);
        $this->assertIsInt($profileData->birthday);

        // Verify grid data
        $this->assertIsArray($profileData->gridNumbers);
        $this->assertIsArray($profileData->gridArrows);
        $this->assertIsArray($profileData->gridInterpretations);
    }

    public function testProfileCreationWithExistingUser(): void
    {
        $fullName = 'Jane Marie Smith';
        $birthDate = CarbonImmutable::create(1985, 3, 22);

        $profileData = $this->action->execute($this->user, $fullName, $birthDate);

        // Verify the profile is associated with the correct user
        $this->assertEquals($this->user->id, $profileData->userId);
    }
}