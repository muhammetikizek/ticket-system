<?php

namespace App\Http\Controllers\API;

use App\Models\OrderTicket;
use App\Http\Controllers\Controller;
use App\Repositories\OrderTicketRepository;
use App\Services\OrderTicketService;
use App\Http\Requests\OrderTicketCreateRequest;

class OrderTicketController extends Controller
{

    public function __construct(
        public OrderTicketService $orderTicketService,
        public OrderTicketRepository $orderTicketRepository
    )
    {
    }

    public function createOrderTicket(OrderTicketCreateRequest $request)
    {
        $data = [
            'storeId' => $request->header('storeId'),
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

    public function getOrderTickets()
    {
        $orderTickets = $this->orderTicketRepository->getOrderTickets();
        return response()->json([
            'code' => 200,
            'success' => true,
            'data' => [
                'totalPrice' => number_format($orderTickets->sum('price'), 2, ',', '.'),
                'orderTickets' => $orderTickets,
            ]
        ]);
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
