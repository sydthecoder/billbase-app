<?php

namespace App\Modules\Auth\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $subscription = $this->organization->activeSubscription;

        return [
            'id'            => $this->id,
            'full_name'     => trim($this->first_name . ' ' . $this->last_name) ?: null,
            'email'         => $this->email,
            'role'          => $this->role,
            'avatar_url'    => $this->avatar_url,
            'organization'  => [
                'id'       => $this->organization->id,
                'org_code' => $this->organization->org_code,
                'name'     => $this->organization->name,
                'email'    => $this->organization->email,
                // 'logo_url' => $this->organization->logo_url, //
                'currency'   => $this->organization->currency,
                'status'     => $this->organization->status,
                'subscription' => [
                    'status'        => $subscription?->status,
                    'trial_ends_at' => $subscription?->trial_ends_at,
                    'is_usable'     => $subscription?->isUsable() ?? false,
                    'plan'          => [
                        'id'   => $subscription?->plan?->id,
                        'name' => $subscription?->plan?->name,
                        'slug' => $subscription?->plan?->slug,
                    ],
                ],
            ],
        ];
    }
}