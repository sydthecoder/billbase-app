<?php

use App\Modules\Invoices\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->prefix('invoices')->group(function () {
    Route::get('/',            [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/create',      [InvoiceController::class, 'create'])->name('invoices.create');
    Route::post('/',           [InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('/{id}',        [InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/{id}/edit',   [InvoiceController::class, 'edit'])->name('invoices.edit');
    Route::put('/{id}',        [InvoiceController::class, 'update'])->name('invoices.update');
    Route::delete('/{id}',     [InvoiceController::class, 'destroy'])->name('invoices.destroy');
    Route::post('/{id}/send',  [InvoiceController::class, 'send'])->name('invoices.send');
    Route::get('/{id}/pdf',    [InvoiceController::class, 'pdf'])->name('invoices.pdf');
});