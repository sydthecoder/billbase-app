<?php

use App\Modules\Settings\Controllers\GeneralController;
use App\Modules\Settings\Controllers\MailController;
use App\Modules\Settings\Controllers\BankAccountController;
use App\Modules\Settings\Controllers\PreferencesController;
use App\Modules\Settings\Controllers\SettingsIndexController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->prefix('settings')->group(function () {
    /*--------------------------------------------------------------------
    | Index — single controller, owns the settings page
    |--------------------------------------------------------------------*/
    Route::get('/', SettingsIndexController::class)->name('settings.index');

    /*--------------------------------------------------------------------
    | General
    |--------------------------------------------------------------------*/
    Route::put('general',       [GeneralController::class, 'update'])->name('settings.general.update');
    Route::post('general/logo', [GeneralController::class, 'uploadLogo'])->name('settings.general.logo');

    /*--------------------------------------------------------------------
    | Mail
    |--------------------------------------------------------------------*/
    Route::put('mail',       [MailController::class, 'update'])->name('settings.mail.update');
    Route::post('mail/test', [MailController::class, 'test'])->name('settings.mail.test');

    /*--------------------------------------------------------------------
    | Bank Account
    |--------------------------------------------------------------------*/
    Route::put('bank-account',  [BankAccountController::class, 'update'])->name('settings.bank-account.update');

    /*--------------------------------------------------------------------
    | Preferences
    |--------------------------------------------------------------------*/
    Route::put('preferences',       [PreferencesController::class, 'update'])->name('settings.preferences.update');

    /*--------------------------------------------------------------------
    | Coming soon
    |--------------------------------------------------------------------*/
});