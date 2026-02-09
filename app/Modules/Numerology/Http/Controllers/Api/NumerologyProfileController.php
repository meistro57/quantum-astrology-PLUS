<?php

declare(strict_types=1);

namespace App\Modules\Numerology\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NumerologyProfile;
use App\Modules\Numerology\Actions\CreateNumerologyProfileAction;
use App\Modules\Numerology\Http\Requests\CreateNumerologyProfileRequest;
use App\Modules\Numerology\Http\Resources\NumerologyProfileResource;
use App\Modules\Numerology\Services\PersonalCyclesCalculator;
use Carbon\CarbonImmutable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response;

final class NumerologyProfileController extends Controller
{
    public function __construct(
        private readonly CreateNumerologyProfileAction $createProfileAction,
        private readonly PersonalCyclesCalculator $cyclesCalculator
    ) {}

    /**
     * List user's numerology profiles
     */
    public function index(): AnonymousResourceCollection
    {
        $profiles = NumerologyProfile::query()
            ->where('user_id', auth()->id())
            ->get();

        return NumerologyProfileResource::collection($profiles);
    }

    /**
     * Create a new numerology profile
     */
    public function store(CreateNumerologyProfileRequest $request): NumerologyProfileResource
    {
        $user = auth()->user();
        $birthDate = CarbonImmutable::parse($request->validated('birth_date'));

        $profileData = $this->createProfileAction->execute(
            $user,
            $request->validated('full_name'),
            $birthDate
        );

        // Save the profile to the database
        NumerologyProfile::createFromDto($profileData);

        return NumerologyProfileResource::fromDto($profileData);
    }

    /**
     * Show a specific numerology profile
     */
    public function show(NumerologyProfile $profile): NumerologyProfileResource
    {
        $this->authorize('view', $profile);

        return NumerologyProfileResource::fromDto($profile->toDto());
    }

    /**
     * Calculate personal cycles for a given date
     */
    public function personalCycles(NumerologyProfile $profile, string $targetDateString): JsonResponse
    {
        $this->authorize('view', $profile);

        $targetDate = CarbonImmutable::parse($targetDateString);
        $birthDate = CarbonImmutable::parse($profile->birth_date);

        $cycles = $this->cyclesCalculator->interpretPersonalCycles(
            $birthDate, 
            $targetDate
        );

        return response()->json([
            'personal_cycles' => $cycles,
            'target_date' => $targetDate->toIso8601String()
        ]);
    }

    /**
     * Delete a numerology profile
     */
    public function destroy(NumerologyProfile $profile): Response
    {
        $this->authorize('delete', $profile);

        $profile->delete();

        return response()->noContent();
    }
}
