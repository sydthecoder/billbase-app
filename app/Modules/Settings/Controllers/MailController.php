<?php

namespace App\Modules\Settings\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Settings\Requests\SaveMailSettingsRequest;
use App\Modules\Settings\Requests\TestMailSettingsRequest;
use App\Modules\Settings\Services\MailService;
use Illuminate\Http\RedirectResponse;

class MailController extends Controller
{
    public function __construct(
        protected MailService $mailService,
    ) {}

    public function update(SaveMailSettingsRequest $request): RedirectResponse
    {
        $this->mailService->save(auth()->user(), $request->validated());

        return back()->with('success', 'Mail settings saved. Send a test email to verify.');
    }

    public function test(TestMailSettingsRequest $request): RedirectResponse
    {
        $result = $this->mailService->test(auth()->user(), $request->validated()['recipient']);

        if ($result['status'] === 'error') {
            return back()->withErrors(['test' => $result['message']]);
        }

        return back()->with('success', $result['message']);
    }
}