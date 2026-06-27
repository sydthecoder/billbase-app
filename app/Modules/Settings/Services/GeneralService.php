<?php

namespace App\Modules\Settings\Services;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class GeneralService
{
    public function get(User $user): Organization
    {
        return $user->organization;
    }

    public function update(User $user, array $data): Organization
    {
        $org = $user->organization;
        $org->update($data);

        return $org->fresh();
    }

    public function uploadLogo(User $user, $file): string
    {
        $org       = $user->organization;
        $extension = $file->getClientOriginalExtension();
        $path      = "logos/{$org->org_code}/logo.{$extension}";

        if ($org->logo_url) {
            \Storage::disk('public')->delete($org->logo_url);
        }

        \Storage::disk('public')->put($path, file_get_contents($file));

        $org->update(['logo_url' => $path]);

        return $path;
    }
}