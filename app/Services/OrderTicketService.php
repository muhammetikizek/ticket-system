<?php

namespace App\Services;


use App\Models\Order;
use App\Enums\OrderStatus;
use App\Models\TicketTime;
use App\Models\OrderTicket;
use Illuminate\Support\Facades\DB;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\Validator;
use App\Repositories\ExternalOrderRepository;
use Illuminate\Validation\ValidationException;

class OrderTicketService
{

    public function __construct(
        public Order $orderModel,
        public OrderTicket $orderTicketModel,
        public OrderRepository $orderRepository,
        public ExternalOrderRepository $externalOrderRepository
    )
    {
    }

    public function createOrderTicket(array $data)
    {
        try {
            return DB::transaction(function () use ($data) {

                if (! session()->has('storeId'))
                {
                    session()->put('storeId', $data['storeId']);
                }

                $storeId = $data['storeId'];

                $ticketTime = TicketTime::find($data['ticketTimeId']);

                $this->validateTicketTimeQuantity($data['ticketTimeId'], $ticketTime->quantity, $data['quantity']);

                return $this->orderTicketModel::create([
                    'ticket_time_id'    => $data['ticketTimeId'],
                    'quantity'      => $data['quantity'],
                    'price'         => floatval($ticketTime->price) * intval($data['quantity']),
                    'status'        => OrderStatus::PENDING->value,
                ]);
            });
        } catch (\Exception $e) {
            throw $e;
        }
    }

    protected function validateTicketTimeQuantity($ticketTimeId, $ticketTimeQuantity, $quantity)
    {
        $quantitySum = $this->orderTicketModel::where('ticket_time_id', $ticketTimeId)->sum('quantity');

        if (($quantitySum + $quantity) > $ticketTimeQuantity)
        {
            $validator = Validator::make([], []);
            $validator->errors()->add('quantity', 'Product quantity is not enough');
            throw new ValidationException($validator);
        }
        return;
    }


    private function createOrder(int $storeId, float $total = 0)
    {
        $order = $this->orderModel::create([
            'store_id' => session('storeId'),
            'total_price' => 0
        ]);
        if (! $order)
        {
            $validator = Validator::make([], []);
            $validator->errors()->add('order', 'Order not created');
            throw new \Illuminate\Validation\ValidationException($validator);
        }
        return $order;
    }

    public function getOrderTicketsWithPendingStatus()
    {
        return $this->orderTicketModel::query()->with(['ticketTime.ticket'])
            ->whereHas('ticketTime.ticket', function ($query) {
                $query->where('store_id', session('storeId'));
            })
            ->where('status', OrderStatus::PENDING->value)
            ->get();
    }

    public function deleteOrderTicket(int $orderTicketId)
    {
        $orderTicket = $this->orderTicketModel::find($orderTicketId);

        if (! $orderTicket)
        {
            $validator = Validator::make([], []);
            $validator->errors()->add('orderTicket', 'Order ticket not found');
            throw new ValidationException($validator);
        }
        $orderTicket->delete();
        return;
    }
}
