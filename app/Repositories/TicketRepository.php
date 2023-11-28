<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Ticket;
use App\Models\TicketTime;

class TicketRepository
{
    public function __construct(
        public Ticket $ticketModel,
        public TicketTime $ticketTimeModel,
    ) {
    }

    public function getTickets()
    {
        return $this->ticketModel
            ->where('store_id', auth()->guard('user')->user()->lastUsedStore->id)
            ->with('times')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getTicket(Ticket $ticket)
    {
        return $ticket->load('times');
    }

    public function getTicketTimes()
    {
        return $this->ticketTimeModel->get();
    }

    public function getTimesByTicketId(int $storeId, int $ticketId = null)
    {
        return $this->ticketTimeModel::query()
        ->when($storeId, function ($query, $storeId) {
            $query->whereHas('ticket', function ($query) use ($storeId) {
                $query->where('store_id', $storeId);
            });
        })
        ->when($ticketId, function ($query, $ticketId) {
            $query->where('ticket_id', $ticketId);
        })
        //->where('time', '>', Carbon::now()->toTimeString())
        ->with(['ticket' => function ($query) {
            $query->select('id', 'name');
        }])
        ->get([
            'id',
            'name',
            'time',
            'quantity',
            'price',
            'currency'
        ])->map(function ($item) {
            $item->remaining_quantity = $this->ticketTimeModel->remaining_quantity;
            return $item;
        });
    }
}
