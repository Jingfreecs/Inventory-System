<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\LowStockController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::resource('products', ProductController::class);

Route::resource('categories', CategoryController::class);

Route::get('/stock-movements', [StockMovementController::class, 'index'])
    ->name('stock-movements.index');

Route::post('/stock-out', [StockMovementController::class, 'storeOut'])
    ->name('stock-out.store');

Route::get('/stock-in', [StockMovementController::class, 'createIn'])
    ->name('stock-in.create');

Route::post('/stock-in', [StockMovementController::class, 'storeIn'])
    ->name('stock-in.store');

Route::get('/low-stock', [LowStockController::class, 'index'])
    ->name('low-stock.index');

Route::get('/reports', [ReportController::class, 'index'])
    ->name('reports.index');

Route::get('/sales', [SaleController::class, 'index'])
    ->name('sales.index');

Route::get('/sales/create', [SaleController::class, 'create'])
    ->name('sales.create');

Route::get('/sales/{sale}', [SaleController::class, 'show'])
    ->name('sales.show');

Route::get('/sales/{sale}/invoice', [SaleController::class, 'invoice'])
    ->name('sales.invoice');

Route::post('/sales/cart', [SaleController::class, 'addToCart'])
    ->name('sales.cart.add');

Route::delete('/sales/cart/{productId}', [SaleController::class, 'removeFromCart'])
    ->name('sales.cart.remove');

Route::delete('/sales/cart', [SaleController::class, 'clearCart'])
    ->name('sales.cart.clear');

Route::post('/sales/checkout', [SaleController::class, 'checkout'])
    ->name('sales.checkout');
