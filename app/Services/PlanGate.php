<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Config;

class PlanGate
{
    /**
     * Check a limit for the given user's plan.
     *
     * Returns true if allowed, false if the limit is exceeded.
     */
    public function allows(User $user, string $limitKey, int $currentCount): bool
    {
        $limit = $this->getLimit($user, $limitKey);

        // null = unlimited, false = feature not available
        if ($limit === null) return true;
        if ($limit === false) return false;

        return $currentCount < $limit;
    }

    /**
     * Get the raw limit value for the user's plan.
     *
     * Returns:
     *  - int: the limit
     *  - null: unlimited
     *  - false: feature not available
     */
    public function getLimit(User $user, string $limitKey): int|null|false
    {
        $slug = $this->getPlanSlug($user);

        if (! $slug) {
            return false; // no active plan = nothing allowed
        }

        return Config::get("plans.{$slug}.limits.{$limitKey}");
    }

    /**
     * Get the plan slug for the authenticated user.
     */
    public function getPlanSlug(User $user): ?string
    {
        return $user->organization
                    ?->activeSubscription
                    ?->plan
                    ?->slug;
    }

    /**
     * Get a friendly plan name for error messages.
     */
    public function getPlanName(User $user): string
    {
        return $user->organization
                    ?->activeSubscription
                    ?->plan
                    ?->name ?? 'Unknown';
    }
}