<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Enums\PaymentTypes;
use App\Models\OrderTicket;
use App\Enums\PaymentStatus;
use App\Services\ResponseService;

class PaymentService
{
    //private $status = PaymentStatus::values();

    //protected $types = PaymentTypes::values();

    //protected $orderStatus = OrderStatus::values();

    public function __construct(
        public ResponseService $responseService,
        public OrderTicket $orderTicketModel,
    )
    {
    }

    public function createCashPayment(array $orderTicketIds)
    {
        // müşteri ad,soyad gibi bilgileri order_tickets tablosu ile ilişkili biçimde kaydediyoruz.

        // İlk olarak order_tickets daki bilgileri alıyoruz

        $orderTickets = OrderTicket::whereIn('id', $orderTicketIds)
            ->where('status', 'pending')
            ->get();

        if ($orderTickets->count() !== count($orderTicketIds))
        {
            return response()->json([
                'message' => 'Order ticket not found.'
            ], 404);
        }
        return $orderTickets;
    }

}
