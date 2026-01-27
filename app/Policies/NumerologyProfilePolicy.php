<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\NumerologyProfile;
use App\Models\User;

final class NumerologyProfilePolicy
{
    /**
     * Determine if the user can view the numerology profile
     */
    public function view(User $user, NumerologyProfile $profile): bool
    {
        return $user->id === $profile->user_id;
    }

    /**
     * Determine if the user can delete the numerology profile
     */
    public function delete(User $user, NumerologyProfile $profile): bool
    {
        return $user->id === $profile->user_id;
    }

    /**
     * Determine if the user can create a new numerology profile
     */
    public function create(User $user): bool
    {
        // Optional: Add subscription tier checks if needed
        return true;
    }
}