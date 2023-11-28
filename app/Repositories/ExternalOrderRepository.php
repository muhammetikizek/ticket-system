<?php

namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class ExternalOrderRepository
{

    private static string $database = '';

    private static array $table = [
        'users' => 'external_users',
        'orders' => 'external_orders',
        'order_tickets' => 'external_order_tickets',
        'ticket_types' => 'external_ticket_types',
        'ticket_times' => 'external_ticket_times',
    ];

    private function table($table)
    {
        return empty(self::$database) 
        ? DB::table($table) 
        : DB::connection(self::$database)->table($table);
    }

    public function getOrdersWithTickets(?string $search = '', string $status = 'pending')
    {
        $orders = self::$table['orders'];
        $orderTickets = self::$table['order_tickets'];
        $users = self::$table['users'];
        return $this->table(self::$table['orders'])
        ->select([
            "$orders.id as orderId",
            "$orders.price as orderPrice",
            "$orders.quantity as orderQuantity",
            "$orders.payment_type as orderPaymentType",
            "$orders.status as orderStatus",
            "$orderTickets.id as orderTicketId",
            "$orderTickets.buy_date as orderTicketBuyDate",
            "$orderTickets.buy_time as orderTicketBuyTime",
            "$orderTickets.type as orderTicketType",
            "$orderTickets.price as orderTicketPrice",
            "$orderTickets.count as orderTicketCount",
            "$orderTickets.created_at as orderTicketCreatedAt",
            "$users.name as userName",
            "$users.surname as userSurname",
            "$users.email as userEmail",
            "$users.phone as userPhone",
        ])
        ->join("$orderTickets", "$orders.id", '=', "$orderTickets.order_id")
        ->join("$users", "$orders.user_id", '=', "$users.id")
        ->where("$orders.status", '=', $status)
        ->when($search, function ($query, $search) use ($users, $orderTickets) {
            return $query->where("$users.name", 'LIKE', '%'.$search.'%')
                        ->orWhere("$users.surname", 'LIKE', '%'.$search.'%')
                        ->orWhere("$users.email", 'LIKE', '%'.$search.'%')
                        ->orWhere("$users.phone", 'LIKE', '%'.$search.'%')
                        ->orWhere("$orderTickets.order_id", 'LIKE', '%'.$search.'%');
        })
        ->get();
    }
}
