<?php

namespace App\Modules\Settings\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Settings\Services\GeneralService;
use App\Modules\Settings\Services\MailService;
use App\Modules\Settings\Services\BankAccountService;
use App\Modules\Settings\Services\PreferenceService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsIndexController extends Controller
{
    public function __construct(
        protected GeneralService $generalService,
        protected MailService    $mailService,
        protected BankAccountService $bankAccountService,
        protected PreferenceService  $preferenceService,
    ) {}

    public function __invoke(Request $request): View
    {
        $allowed = ['general', 'mail', 'bank-account', 'preferences'];

        $tab = in_array($request->query('tab'), $allowed)
            ? $request->query('tab')
            : 'general';

        return view('settings.index', [
            'tab'          => $tab,
            'organization' => $this->generalService->get(auth()->user()),
            'mailSetting'  => $this->mailService->get(auth()->user()),
            'bankAccount'  => $this->bankAccountService->get(auth()->user()),
            'preferences'  => $this->preferenceService->get(auth()->user()),
        ]);
    }
}