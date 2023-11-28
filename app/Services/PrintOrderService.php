<?php

namespace App\Services;

use App\Jobs\PrintOrderWithPDF;
use App\Models\Order;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Validator;

class PrintOrderService
{
    public function printOrder(int $orderId)
    {
        if (! $orderId)
        {
            return response()->json([
                'error' => 'orderId is required.'
            ], 400);
        }
        $order = Order::findOrFail($orderId);
        PrintOrderWithPDF::dispatch($order);
        return [
            'printed' => true,
            'message' => 'Your order is being printed',
        ];
    }
}
