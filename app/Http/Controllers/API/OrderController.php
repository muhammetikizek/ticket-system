<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Http\Requests\OrderCreateRequest;
use App\Repositories\ExternalOrderRepository;

class OrderController extends Controller
{

    public function __construct(
        public OrderRepository $orderRepository,
        public OrderService $orderService,
        public ExternalOrderRepository $externalOrderRepository
    )
    {
    }

    public function createOrder(OrderCreateRequest $request)
    {
        $data = [
            'storeId' => $request->storeId,
            'ticketId' => $request->ticketId,
            'ticketTimeId' => $request->ticketTimeId,
            'quantity' => $request->quantity,
            'price' => 0,
        ];

        $response = $this->orderService->createOrder($data);

        return response()->json([
            'data' => $response,
        ], 201);
    }

    public function getOrdersWithPendingStatus()
    {
        $data = $this->orderRepository->getOrdersWithPendingStatus();

        return response()->json([
            'total' => $data->sum('price'),
            'data' => $data,
        ]);
    }

    public function deleteOrder(int $orderId)
    {
        return $this->orderService->deleteOrder($orderId);
    }
}
