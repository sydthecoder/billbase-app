<?php

namespace App\Modules\Settings\Services;

use App\Models\OrganizationPreference;
use App\Models\User;

class PreferenceService
{
    public function get(User $user): ?OrganizationPreference
    {
        return OrganizationPreference::where('organization_id', $user->organization_id)->first();
    }

    public function update(User $user, array $data): OrganizationPreference
    {
        return OrganizationPreference::updateOrCreate(
            ['organization_id' => $user->organization_id],
            $data,
        );
    }
}