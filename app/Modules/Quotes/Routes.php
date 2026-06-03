<?php

use App\Modules\Quotes\Controllers\QuoteController;
use Illuminate\Support\Facades\Route;

/**
 * Default throttle (60/min per user) applied to all routes.
 * PDF endpoints further restricted to 10/min.
 */
Route::prefix('v1/quotes')->middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::get('/',              [QuoteController::class, 'index']);
    Route::post('/',             [QuoteController::class, 'store']);
    Route::get('/{id}',          [QuoteController::class, 'show']);
    Route::put('/{id}',          [QuoteController::class, 'update']);
    Route::delete('/{id}',       [QuoteController::class, 'destroy']);
    Route::patch('/{id}/status', [QuoteController::class, 'updateStatus']);

    // PDF generation — heavier operation, stricter limit
    Route::get('/{id}/pdf',          [QuoteController::class, 'pdf'])
        ->middleware('throttle:10,1');
    Route::get('/{id}/pdf/download', [QuoteController::class, 'pdfDownload'])
        ->middleware('throttle:10,1');
});