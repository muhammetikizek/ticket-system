<?php

namespace App\Http\Controllers\Admin;

use App\Models\Store;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TicketCreateRequest;
use App\Repositories\Admin\TicketRepository;

class TicketController extends Controller
{

    public function __construct(
        public TicketRepository $ticketRepository,
    )
    {
    }

    public function index(Request $request)
    {
        $tickets = Ticket::with('times')
        ->when(session()->has('adminStoreId'), function ($query) {
            $query->where('store_id', session('adminStoreId'));
        })
        ->orderBy('created_at', 'desc')
        ->paginate($request->limit ?? 25);
        return view('admin.ticket.index', compact('tickets'));
    }

    public function create()
    {
        $stores = Store::all();
        return view('admin.ticket.create', compact('stores'));
    }

    public function edit(Ticket $ticket)
    {
        $ticket = $this->ticketRepository->getTicket($ticket);
        return view('admin.ticket.edit', compact('ticket'));
    }
}
