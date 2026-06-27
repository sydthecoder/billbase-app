<?php

use App\Modules\Products\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'throttle:api'])->prefix('products')->group(function () {
    Route::get('/',          [ProductController::class, 'index'])->name('products.index');
    Route::get('/create',    [ProductController::class, 'create'])->name('products.create');
    Route::post('/',         [ProductController::class, 'store'])->name('products.store');
    Route::get('/{id}',      [ProductController::class, 'show'])->name('products.show');
    Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/{id}',      [ProductController::class, 'update'])->name('products.update');
    Route::delete('/{id}',   [ProductController::class, 'destroy'])->name('products.destroy');
});