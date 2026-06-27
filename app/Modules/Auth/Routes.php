<?php

use App\Modules\Auth\Controllers\AuthController;
use App\Modules\Auth\Controllers\GoogleAuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    Route::get('login',    [AuthController::class, 'showLogin'])->name('login');
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');

    Route::post('login',    [AuthController::class, 'login'])->middleware('throttle:50,15');
    Route::post('register', [AuthController::class, 'register'])->middleware('throttle:50,15');

    Route::middleware(['auth', 'throttle:60,1'])->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });

    // Google OAuth
    Route::get('auth/google',          [GoogleAuthController::class, 'redirect'])->name('auth.google');
    Route::get('auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
});