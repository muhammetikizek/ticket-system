<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{

    public function __construct(
        public OrderService $orderService
    )
    {
    }

    public function index(Request $request)
    {
        $sortables = [
            'price' => $request->sort_price,
            'created_at' => $request->sort_created_at,
            'quantity' => $request->sort_quantity,
        ];
        $orders = $this->orderService->getOrders($sortables);
        return view('admin.order.index', [
            'orders' => $orders,
        ]);
    }
}
