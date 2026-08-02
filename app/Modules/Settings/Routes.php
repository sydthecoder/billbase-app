<?php

use App\Modules\Settings\Controllers\GeneralController;
use App\Modules\Settings\Controllers\MailController;
use App\Modules\Settings\Controllers\BankAccountController;
use App\Modules\Settings\Controllers\PreferencesController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->prefix('settings')->name('settings.')->group(function () {

    /*--------------------------------------------------------------------
    | General
    |--------------------------------------------------------------------*/
    Route::get('general',       [GeneralController::class, 'index'])->name('general.index');
    Route::put('general',       [GeneralController::class, 'update'])->name('general.update');
    Route::post('general/logo', [GeneralController::class, 'uploadLogo'])->name('general.logo');

    /*--------------------------------------------------------------------
    | Mail
    |--------------------------------------------------------------------*/
    Route::get('mail',       [MailController::class, 'index'])->name('mail.index');
    Route::put('mail',       [MailController::class, 'update'])->name('mail.update');
    Route::post('mail/test', [MailController::class, 'test'])->name('mail.test');

    /*--------------------------------------------------------------------
    | Bank Account
    |--------------------------------------------------------------------*/
    Route::get('bank-account', [BankAccountController::class, 'index'])->name('bank-account.index');
    Route::put('bank-account', [BankAccountController::class, 'update'])->name('bank-account.update');

    /*--------------------------------------------------------------------
    | Preferences
    |--------------------------------------------------------------------*/
    Route::get('preferences', [PreferencesController::class, 'index'])->name('preferences.index');
    Route::put('preferences', [PreferencesController::class, 'update'])->name('preferences.update');

    /*--------------------------------------------------------------------
    | Coming soon
    |--------------------------------------------------------------------*/
});

// Redirect the old /settings root somewhere sensible (default page)
Route::redirect('/settings', '/settings/general')->middleware(['web', 'auth']);