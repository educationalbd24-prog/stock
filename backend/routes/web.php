<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PosController;
use App\Http\Controllers\Admin\ProductManagementController;
use App\Http\Controllers\Admin\ShopManagerController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin');

Route::prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/products', [ProductManagementController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductManagementController::class, 'store'])->name('products.store');
    Route::put('/products/{product}', [ProductManagementController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductManagementController::class, 'destroy'])->name('products.destroy');

    Route::get('/managers', [ShopManagerController::class, 'index'])->name('managers.index');
    Route::post('/managers', [ShopManagerController::class, 'store'])->name('managers.store');
    Route::patch('/managers/{manager}', [ShopManagerController::class, 'update'])->name('managers.update');

    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('/pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');
});
