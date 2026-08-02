<?php

namespace App\Modules\Settings\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Settings\Requests\UpdateGeneralRequest;
use App\Modules\Settings\Services\GeneralService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GeneralController extends Controller
{
    public function __construct(
        protected GeneralService $generalService,
    ) {}

    public function index(): View
    {
        return view('settings.general', [
            'organization' => $this->generalService->get(auth()->user()),
        ]);
    }

    public function update(UpdateGeneralRequest $request): RedirectResponse
    {
        $this->generalService->update(auth()->user(), $request->validated());

        return back()->with('success', 'Organization updated.');
    }

    public function uploadLogo(Request $request): RedirectResponse
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $this->generalService->uploadLogo(auth()->user(), $request->file('logo'));

        return back()->with('success', 'Logo uploaded.');
    }
}