<?php

use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\OrderTicketController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(LoginController::class)->middleware(['web'])->group(function () {

    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login')->name('login');
});

Route::middleware(['web','admin'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::prefix('orders')->name('order.')->group(function () {

        Route::get('/', [OrderController::class, 'index'])->name('index');
    });

    Route::prefix('stores')->name('store.')->group(function () {

        Route::get('/{storeId}/switch', [StoreController::class, 'switchStore'])->name('switch');
        Route::get('/', [StoreController::class, 'index'])->name('index');
        Route::get('/create', [StoreController::class, 'create'])->name('create');
        Route::post('/create', [StoreController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [StoreController::class, 'edit'])->name('edit');
        Route::post('/edit/{id}', [StoreController::class, 'update'])->name('update');
    });

    Route::prefix('tickets')->name('ticket.')->group(function () {

        Route::get('/', [TicketController::class, 'index'])->name('index');
        Route::get('/create', [TicketController::class, 'create'])->name('create');
        Route::get('/edit/{ticket}', [TicketController::class, 'edit'])->name('edit');
        Route::get('/orders', [OrderTicketController::class, 'index'])->name('order.index');
    });

    Route::prefix('products')->name('product.')->group(function () {

        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/create', [ProductController::class, 'store'])->name('store');
    });

    Route::prefix('users')->name('user.')->group(function () {

        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::post('/{user}/edit', [UserController::class, 'update'])->name('edit');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/create', [UserController::class, 'store'])->name('create');
    });

    Route::prefix('settings')->group(function () {

        Route::get('/', [SettingController::class, 'index'])->name('setting');

    });

    Route::prefix('customers')->name('customer.')->group(function () {

        Route::get('/', [CustomerController::class, 'index'])->name('index');
        Route::get('/{customerId}/edit', [CustomerController::class, 'edit'])->name('edit');
    });

    Route::prefix('reservations')->name('reservation.')->group(function () {

    });
});
