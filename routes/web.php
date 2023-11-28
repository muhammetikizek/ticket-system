<?php

use App\Http\Controllers\API\OrderController as APIOrderController;
use App\Http\Controllers\CategoryController;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('web');
Route::post('/login', [LoginController::class, 'login'])->name('login')->middleware('web');

Route::middleware(['auth:user', 'check.access.store'])->group(function () {

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::name('order.')->group(function () {
        Route::get('/', [OrderController::class, 'create'])->name('create');
        Route::post('/', [OrderController::class, 'createOrder'])->name('store');
    });

    Route::prefix('api')->name('api')->group(function () {

        Route::prefix('externals')->name('external.')->group(function () {
            Route::get('/orders', [APIOrderController::class, 'getOrdersWithTickets'])->name('orders');
        });

        Route::get('/products', [ProductController::class, 'getProducts']);
        Route::get('/categories/sync', [CategoryController::class, 'createCategory']);
    });

    Route::prefix('stores')->name('store.')->group(function () {
        Route::get('/{storeId}/switch', [StoreController::class, 'switchStore'])->name('switch');
    });

    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
    });
});
