<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TicketCreateRequest;
use App\Http\Requests\TicketUpdateRequest;
use App\Repositories\TicketRepository;
use App\Models\Ticket;

class TicketController extends Controller
{

    public function __construct(
        public TicketRepository $ticketRepository
    )
    {
    }

    public function getTickets()
    {
        $tickets = $this->ticketRepository->getTickets();
        return response()->json([
            'code' => 200,
            'success' => true,
            'data' => $tickets
        ], 200);
    }

    public function getTimesByTicketId(Request $request)
    {
        $storeId = auth()->guard('user')->user()->lastUsedStore->id;
        $ticketId = $request->ticketId;
        $times = $this->ticketRepository->getTimesByTicketId($storeId, $ticketId);
        return response()->json([
            'code' => 200,
            'success' => true,
            'data' => $times
        ], 200);
    }
}
