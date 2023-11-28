<?php

namespace App\Http\Controllers\API;

use App\Models\OrderTicket;
use Illuminate\Http\Request;
use App\Services\PaymentService;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{

    public function __construct(
        public PaymentService $paymentService
    )
    {
    }

    public function createCashPayment(Request $request)
    {
        $orderTicketIds = $request->orderTicketIds;

        $response = $this->paymentService->createCashPayment($orderTicketIds);

        return response()->json([
            'data' => $response,
        ], 201);
    }
}
