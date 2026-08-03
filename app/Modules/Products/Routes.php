<?php

use App\Modules\Products\Controllers\ProductController;
use App\Modules\Products\Controllers\ProductCategoryController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'throttle:api'])->prefix('products')->group(function () {
    Route::get('/',          [ProductController::class, 'index'])->name('products.index');
    Route::get('/create',    [ProductController::class, 'create'])->name('products.create');
    Route::post('/',         [ProductController::class, 'store'])->name('products.store');

    // Categories — plain form-based CRUD, same pattern as Products.
    // Must stay ABOVE /{id} below — otherwise "categories" gets swallowed
    // by the {id} wildcard.
    Route::get('/categories',            [ProductCategoryController::class, 'index'])->name('products.categories.index');
    Route::get('/categories/create',     [ProductCategoryController::class, 'create'])->name('products.categories.create');
    Route::post('/categories',           [ProductCategoryController::class, 'store'])->name('products.categories.store');
    Route::get('/categories/{id}/edit',  [ProductCategoryController::class, 'edit'])->name('products.categories.edit');
    Route::put('/categories/{id}',       [ProductCategoryController::class, 'update'])->name('products.categories.update');
    Route::delete('/categories/{id}',    [ProductCategoryController::class, 'destroy'])->name('products.categories.destroy');

    Route::get('/{id}',      [ProductController::class, 'show'])->name('products.show');
    Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/{id}',      [ProductController::class, 'update'])->name('products.update');
    Route::delete('/{id}',   [ProductController::class, 'destroy'])->name('products.destroy');
});