<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TicketCreateRequest;
use App\Http\Requests\TicketUpdateRequest;
use App\Repositories\TicketRepository;
use App\Repositories\Admin\TicketRepository as AdminTicketRepository;
use App\Models\Ticket;

class TicketController extends Controller
{

    public function __construct(
        public TicketRepository $ticketRepository,
        public AdminTicketRepository $adminTicketRepository
    )
    {
    }


    public function createTicket(TicketCreateRequest $request)
    {
        $data = $this->adminTicketRepository->createTicket($request->validated());
        return response()->json([
            'statusCode' => 201,
            'success' => true,
            'message' => 'Ticket created successfully',
            'data' => $data
        ], 201);
    }

    public function updateTicket(TicketUpdateRequest $request, Ticket $ticket)
    {
        $data = $this->adminTicketRepository->updateTicket($ticket, $request->validated());
        return response()->json([
            'statusCode' => 200,
            'success' => true,
            'message' => 'Ticket updated successfully',
            'data' => $data
        ], 200);
    }

    public function getTicket(Ticket $ticket)
    {
        return response()->json([
            'statusCode' => 200,
            'success' => true,
            'data' => $this->adminTicketRepository->getTicket($ticket)
        ], 200);
    }

    public function getTickets()
    {
        return response()->json([
            'statusCode' => 200,
            'success' => true,
            'data' => $this->adminTicketRepository->getTickets()
        ], 200);
    }

    public function getTimesByTicketId(Request $request)
    {
        $request->validate([
            'ticketId' => [
                'required', 'integer', 'exists:tickets,id'
            ]
        ]);
        return response()->json([
            'statusCode' => 200,
            'success' => true,
            'data' => $this->ticketRepository->getTimesByTicketId($request->header('storeId'), $request->ticketId)
        ], 200);
    }
}
