<?php

namespace App\Http\Controllers;

use App\Repositories\OrderRepository;
use App\Services\OrderService;
use Illuminate\Http\Request;
use App\Http\Requests\OrderCreateRequest;
use App\Repositories\ProductRepository;
use App\Repositories\TicketRepository;

class OrderController extends Controller
{

    public function __construct(
        public OrderService $orderService,
        public OrderRepository $orderRepository,
        public TicketRepository $ticketRepository
    )
    {
    }

    public function create()
    {
        $onlineOrderCount = 0;
        $onsiteOrderCount = 0;
        $todayTotalOrderCount = 0;

        $tickets = $this->ticketRepository->getTickets();
        $ticketTimes = $this->ticketRepository->getTicketTimes();

        return view('order.create', compact(
            'tickets',
            'ticketTimes',
            'onlineOrderCount',
            'onsiteOrderCount',
            'todayTotalOrderCount'
        ));
    }

    public function createOrder(OrderCreateRequest $request)
    {
        $data = [
            'storeId' => $request->storeId,
            'productId' => $request->productId,
            'quantity' => $request->quantity,
            'price' => 0,
        ];

        $response = $this->orderService->createOrder($data);

        return response()->json([
            'data' => $response,
        ], 201);
    }

    public function getOnlineOrder()
    {
        return $this->orderRepository->getOnlineOrderCount();
    }
}
