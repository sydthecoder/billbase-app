<?php

use App\Modules\Auth\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/auth')->group(function () {
    Route::post('register', [AuthController::class, 'register'])
        ->middleware('throttle:50,15');

    Route::post('login', [AuthController::class, 'login'])
        ->middleware('throttle:50,15');

    /**
     * Default throttle (60/min per user) applied to all routes.
     */
    Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });
});