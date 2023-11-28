<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderTicket;
use App\Repositories\OrderTicketRepository;
use App\Services\OrderTicketService;

class OrderTicketController extends Controller
{

    public function __construct(
        public OrderTicketService $orderTicketService,
        public OrderTicketRepository $orderTicketRepository
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
        $orderTickets = $this->orderTicketRepository->getOrderTicketsForAdminPanel($sortables);
        return view('admin.ticket.order.index', compact('orderTickets'));
    }
}
