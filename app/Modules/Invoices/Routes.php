<?php

use App\Modules\Invoices\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

/**
 * Default throttle (60/min per user) applied to all routes.
 * PDF endpoints further restricted to 10/min.
 */
Route::prefix('v1/invoices')->middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::get('/',           [InvoiceController::class, 'index']);
    Route::post('/',          [InvoiceController::class, 'store']);
    Route::get('/{id}',       [InvoiceController::class, 'show']);
    Route::put('/{id}',       [InvoiceController::class, 'update']);
    Route::post('/{id}/send', [InvoiceController::class, 'send']);
    Route::delete('/{id}',    [InvoiceController::class, 'destroy']);

    // PDF generation — heavier operation, stricter limit
    Route::get('/{id}/pdf',   [InvoiceController::class, 'pdf'])
        ->middleware('throttle:10,1');
});