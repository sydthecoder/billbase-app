<?php

namespace App\Modules\Settings\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Settings\Requests\UpdatePreferencesRequest;
use App\Modules\Settings\Services\PreferenceService;
use Illuminate\Http\RedirectResponse;

class PreferencesController extends Controller
{
    public function __construct(
        protected PreferenceService $preferenceService,
    ) {}

    public function update(UpdatePreferencesRequest $request): RedirectResponse
    {
        $this->preferenceService->update(auth()->user(), $request->validated());

        return back()->with('success', 'Preferences saved.');
    }
}