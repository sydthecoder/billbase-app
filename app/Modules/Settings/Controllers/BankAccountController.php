<?php

namespace App\Modules\Settings\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Settings\Requests\SaveBankAccountRequest;
use App\Modules\Settings\Services\BankAccountService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BankAccountController extends Controller
{
    public function __construct(
        protected BankAccountService $bankAccountService,
    ) {}

    public function index(): View
    {
        return view('settings.bank-account', [
            'bankAccount' => $this->bankAccountService->get(auth()->user()),
        ]);
    }

    public function update(SaveBankAccountRequest $request): RedirectResponse
    {
        $this->bankAccountService->save(auth()->user(), $request->validated());

        return back()->with('success', 'Bank account saved.');
    }
}