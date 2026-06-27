<?php

use App\Modules\Customers\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'throttle:api'])->prefix('customers')->group(function () {
    Route::get('/',            [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/create',      [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/',           [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/{id}',        [CustomerController::class, 'show'])->name('customers.show');
    Route::get('/{id}/edit',   [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/{id}',        [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/{id}',     [CustomerController::class, 'destroy'])->name('customers.destroy');
});