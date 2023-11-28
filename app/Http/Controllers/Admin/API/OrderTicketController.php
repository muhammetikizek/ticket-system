<?php

namespace App\Http\Controllers\API;

use App\Models\OrderTicket;
use App\Http\Controllers\Controller;
use App\Services\OrderTicketService;
use App\Http\Requests\OrderTicketCreateRequest;

class OrderTicketController extends Controller
{

    public function __construct(
        public OrderTicketService $orderTicketService
    )
    {
    }

    public function createOrderTicket(OrderTicketCreateRequest $request)
    {
        $data = [
            'storeId' => $request->storeId,
            'ticketId' => $request->ticketId,
            'ticketTimeId' => $request->ticketTimeId,
            'quantity' => $request->quantity,
            'price' => 0,
        ];

        $response = $this->orderTicketService->createOrderTicket($data);

        return response()->json([
            'data' => $response,
        ], 201);
    }

    public function getOrderTicketsWithPendingStatus()
    {
        $response = $this->orderTicketService->getOrderTicketsWithPendingStatus();
        return response()->json([
            'totalPrice' => number_format($response->sum('price'), 2, ',', '.'),
            'data' => $response
        ]);
    }

    public function deleteOrderTicket($orderTicketId)
    {
        $this->orderTicketService->deleteOrderTicket($orderTicketId);
        return response()->json(null, 204);
    }
}
