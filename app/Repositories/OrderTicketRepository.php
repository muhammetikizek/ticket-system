<?php

namespace App\Repositories;

use App\Enums\OrderStatus;
use App\Models\OrderTicket;

class OrderTicketRepository
{

    public function __construct(
        public OrderTicket $orderTicketModel
    ) {
    }

    public function getOrderTickets()
    {
        return $this->orderTicketModel::query()
            ->with(['ticketTime.ticket'])
            ->whereHas('ticketTime.ticket', function ($query) {
                $query->where('store_id', session('storeId'));
            })
            ->where('status', OrderStatus::PENDING->value)
            ->get();
    }

    public function getOrderTicketsWithPendingStatus()
    {
        return $this->orderTicketModel::with('ticketTime.ticket')->where('status', 'pending')->paginate(25);
    }

    public function deleteOrderTicket($orderTicketId)
    {
        return $this->orderTicketModel::find($orderTicketId)->delete();
    }

    public function getOrderTicketsForAdminPanel(array $sortables = [], $paginate = 25)
    {
        return $this->orderTicketModel::query()
            ->with(['ticketTime.ticket'])
            ->whereHas('ticketTime.ticket', function ($query) {
                $query->when(session()->has('adminStoreId'), function ($query) {
                    $query->where('store_id', session('adminStoreId'));
                });
            })
            ->when($sortables, function ($query) use ($sortables) {
                foreach (array_filter($sortables) as $key => $value) {
                    $query->orderBy($key, $value);
                }
            })
            ->paginate($paginate);
    }
}
