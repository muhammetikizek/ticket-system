<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\TicketController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\TicketTimeController;
use App\Http\Controllers\API\OrderTicketController;


Route::get('/tickets', [TicketController::class, 'getTickets'])->name('ticket.list');
Route::get('/tickets/times', [TicketController::class, 'getTimesByTicketId'])->name('ticket.times');


Route::prefix('tickets')->name('ticket.')->group(function () {

    Route::post('/', [TicketController::class, 'createTicket'])->name('create');
    Route::delete('/{ticketId}/time', [TicketTimeController::class, 'deleteTicketTime'])->name('time.delete');
    Route::put('/{ticket}', [TicketController::class, 'updateTicket'])->name('update');
    Route::get('/{ticket}', [TicketController::class, 'getTicket'])->name('show');
});

Route::prefix('orders')->name('order.')->group(function () {

    #: api/orders/tickets
    Route::post('/tickets', [OrderTicketController::class, 'createOrderTicket'])->name('create');
    #: api/orders/tickets
    Route::get('/tickets', [OrderTicketController::class, 'getOrderTickets']);
    Route::get('/status/pending',[OrderTicketController::class, 'getOrderTicketsWithPendingStatus'])->name('status.pending');
    Route::delete('/tickets/{order}',[OrderTicketController::class, 'deleteOrderTicket'])->name('ticket.delete');



    Route::post('/payment/cash', [PaymentController::class, 'createCashPayment'])->name('payment.cash');
});
