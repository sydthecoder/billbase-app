<?php

use App\Modules\Quotes\Controllers\QuoteController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->prefix('quotes')->group(function () {
    Route::get('/',              [QuoteController::class, 'index'])->name('quotes.index');
    Route::get('/create',        [QuoteController::class, 'create'])->name('quotes.create');
    Route::post('/',             [QuoteController::class, 'store'])->name('quotes.store');
    Route::get('/{id}',          [QuoteController::class, 'show'])->name('quotes.show');
    Route::get('/{id}/edit',     [QuoteController::class, 'edit'])->name('quotes.edit');
    Route::put('/{id}',          [QuoteController::class, 'update'])->name('quotes.update');
    Route::delete('/{id}',       [QuoteController::class, 'destroy'])->name('quotes.destroy');
    Route::post('/{id}/send',    [QuoteController::class, 'send'])->name('quotes.send');
    Route::post('/{id}/status',  [QuoteController::class, 'updateStatus'])->name('quotes.status');
    Route::get('/{id}/pdf',      [QuoteController::class, 'pdf'])->name('quotes.pdf');
});