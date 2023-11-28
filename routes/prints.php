<?php

use App\Http\Controllers\PrintController;
use Illuminate\Support\Facades\Route;

Route::controller(PrintController::class)->group(function () {

    Route::post('/order', 'printOrder')->name('order');
});
