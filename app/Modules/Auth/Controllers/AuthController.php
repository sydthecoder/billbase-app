<?php

namespace App\Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\OrganizationSubscription;
use App\Models\Plan;
use App\Models\User;
use App\Modules\Auth\Requests\LoginRequest;
use App\Modules\Auth\Requests\RegisterRequest;
use App\Services\CodeGeneratorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $slug = $request->plan_slug ?? 'free';
            $plan = Plan::where('slug', $slug)->where('is_active', true)->first();

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
                'first_name'      => 'System',
                'last_name'       => 'Admin',
                'email'           => $request->email,
                'password'        => Hash::make($request->password),
                'role'            => 'owner',
            ]);

            DB::commit();

            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->route('dashboard');

        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->withErrors([
                'general' => $e->getMessage(),
            ])->withInput();
        }
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Invalid credentials.',
            ])->withInput($request->only('email'));
        }

        $user->update(['last_login_at' => now()]);

        Auth::login($user);
        $request->session()->regenerate();

        $user->load('organization.activeSubscription.plan');

        return redirect()->intended(route('dashboard'));
    }

    public function logout(): RedirectResponse
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login');
    }
}