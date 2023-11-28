<?php

namespace App\Repositories\Admin;

use App\Models\Ticket;
use App\Models\TicketTime;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TicketRepository
{

    public function __construct(
        public Ticket $ticketModel,
        public TicketTime $ticketTimeModel,
    ) {
    }

    public function getTickets(int $limit = 25)
    {
        return $this->ticketModel
        ->with('times')
        ->when(session()->has('ActiveStoreId'), function ($query) {
            $query->where('store_id', session('ActiveStoreId'));
        })
        ->orderBy('created_at', 'desc')
        ->paginate($limit);
    }

    public function createTicket(array $data)
    {
        return DB::transaction(function () use ($data) {

            $ticket = $this->ticketModel->create([
                'store_id' => $data['store_id'],
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'description' => $data['description'],
            ]);

            if ($ticket) {
                foreach ($data['times'] as $time) {
                    $ticket->times()->create([
                        'name' => $time['time'],
                        'time' => $time['time'],
                        'quantity' => $time['quantity'],
                        'price' => $time['price'],
                    ]);
                }
                return $ticket->with('times')->find($ticket->id);
            }
        });
    }

    public function updateTicket(Ticket $ticket, array $data)
    {
        return DB::transaction(function () use ($ticket, $data) {

            $ticket->update([
                'store_id' => $data['store_id'],
                'name' => $data['name'],
                'slug' => Str::slug($data['name']),
                'description' => $data['description'],
                'enabled' => $data['enabled'] ?? '0',
            ]);

            if ($ticket) {
                foreach ($data['times'] as $time) {
                    $ticket->times()->updateOrCreate(
                        [
                            'ticket_id' => $ticket->id,
                            'time' => $time['time'],
                        ],
                        [
                            'name' => $time['time'],
                            'quantity' => $time['quantity'],
                            'price' => $time['price'],
                        ]
                    );
                }
                return $ticket->load('times');
            }
        });
    }

    public function getTicket(Ticket $ticket)
    {
        return $ticket->load('times');
    }
}
