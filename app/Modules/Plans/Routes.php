<?php

use App\Modules\Plans\Controllers\PlanController;
use Illuminate\Support\Facades\Route;

/**
 * Default throttle (60/min per user) applied to all routes.
 */
Route::prefix('v1')->middleware('throttle:api')->group(function () {
    Route::get('plans', [PlanController::class, 'index']);
});