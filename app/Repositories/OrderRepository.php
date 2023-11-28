<?php

namespace App\Repositories;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderRepository
{

    public function __construct(
        public Order $orderModel
    ) {
    }

    public function getOrdersWithPendingStatus()
    {
        return $this->orderModel::with('ticketTime.ticket')
            //->where('store_id', $storeId)
            ->where('status', OrderStatus::PENDING->value)
            ->get();
    }

    public function getOnlineOrderCount()
    {
        return $this->orderModel::where('status', 'pending')->isOnline()->count();
    }

    public function getOnsiteOrderCount()
    {
        return $this->orderModel::where('status', 'pending')->onsite()->count();
    }

    public function getTodayOrderCount()
    {
        return $this->orderModel::where('status', 'Completed')
            ->whereDate('created_at', today())
            ->count();
    }

    public function getOrderQuantitySumByTicketTimeId(int $ticketTimeId)
    {
        return $this->orderModel::where('ticket_time_id', $ticketTimeId)->sum('quantity');
    }
}
