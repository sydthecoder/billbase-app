<?php

namespace App\Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\OrganizationSubscription;
use App\Models\Plan;
use App\Models\User;
use App\Services\CodeGeneratorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Throwable $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Google authentication failed. Please try again.',
            ]);
        }

        DB::beginTransaction();

        try {
            // Find existing user by google_id or email
            $user = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            if ($user) {
                // Existing user — ensure google_id is linked
                $user->update(['google_id' => $googleUser->getId()]);

            } else {
                // New user — same flow as normal registration
                $plan = Plan::where('slug', 'free')->where('is_active', true)->first();

                $organization = Organization::create([
                    'name'     => 'Bill Base',
                    'org_code' => CodeGeneratorService::organization(),
                    'country'  => 'ZA',
                    'currency' => 'ZAR',
                    'status'   => 'active',
                ]);

                OrganizationSubscription::create([
                    'organization_id' => $organization->id,
                    'plan_id'         => $plan->id,
                    'status'          => OrganizationSubscription::STATUS_TRIALING,
                    'trial_ends_at'   => now()->addDays(14),
                ]);

                $user = User::create([
                    'organization_id' => $organization->id,
                    'first_name'      => $googleUser->user['given_name']  ?? $googleUser->getName(),
                    'last_name'       => $googleUser->user['family_name'] ?? '',
                    'email'           => $googleUser->getEmail(),
                    'google_id'       => $googleUser->getId(),
                    'password'        => null,
                    'role'            => 'owner',
                ]);
            }

            DB::commit();

            $user->update(['last_login_at' => now()]);

            Auth::login($user);
            request()->session()->regenerate();

            return redirect()->intended(route('dashboard'));

        } catch (\Throwable $e) {
    DB::rollBack();

    return redirect()->route('login')->withErrors([
        'email' => $e->getMessage(),
    ]);
}
    }
}