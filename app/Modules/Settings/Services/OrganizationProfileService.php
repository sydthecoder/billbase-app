<?php

namespace App\Modules\Settings\Services;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class OrganizationProfileService
{
    public function get(User $user): JsonResponse
    {
        $org = $user->organization;

        return response()->json([
            'status' => 'success',
            'data'   => $this->formatOrg($org),
        ]);
    }

    public function update(User $user, array $data): JsonResponse
    {
        $org = $user->organization;
        $org->update($data);

        return response()->json([
            'status' => 'success',
            'data'   => $this->formatOrg($org->fresh()),
        ]);
    }

    private function formatOrg(Organization $org): array
    {
        return [
            'id'       => $org->id,
            'org_code' => $org->org_code,
            'name'     => $org->name,
            'email'    => $org->email,
            'phone'    => $org->phone,
            'address'  => [
                'street_address' => $org->street_address,
                'suburb'         => $org->suburb,
                'city'           => $org->city,
                'province'       => $org->province,
                'postal_code'    => $org->postal_code,
                'country'        => $org->country,
            ],
            'reg_number' => $org->reg_number,
            'tax_number' => $org->tax_number,
            'currency'   => $org->currency,
            'status'     => $org->status,
            'logo_url' => $org->logo_url,
        ];
    }

    public function uploadLogo(User $user, $file): JsonResponse
    {
        $org = $user->organization;

        $extension = $file->getClientOriginalExtension();
        $filename  = 'logo.' . $extension;
        $path      = "logos/{$org->org_code}/{$filename}";

        // Delete old logo from R2 if exists
        if ($org->logo_filename) {
            Storage::disk('r2')->delete($org->logo_filename);
        }

        // Upload to R2
        Storage::disk('r2')->put($path, file_get_contents($file), 'public');

        // Save full public URL
        $publicUrl = env('CLOUDFLARE_R2_PUBLIC_URL') . '/' . $path;
        $org->update(['logo_filename' => $publicUrl]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Logo uploaded successfully.',
            'data'    => ['logo_url' => $publicUrl],
        ]);
    }
}