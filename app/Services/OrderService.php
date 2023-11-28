<?php

namespace App\Services;


use App\Enums\OrderStatus;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderTicket;
use App\Models\Product;
use App\Models\TicketTime;
use App\Repositories\ExternalOrderRepository;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderService
{

    public function __construct(
        public Order $orderModel,
        public OrderTicket $orderTicketModel,
        public OrderRepository $orderRepository,
        public ExternalOrderRepository $externalOrderRepository
    )
    {
    }

    public function getECommerceOrders(?string $search)
    {
        $data = $this->externalOrderRepository->getOrdersWithTickets($search);

        if ($data->isEmpty())
        {
            return response()->json([
                'error' => 'Order not found.'
            ], 404);
        }

        $data = $data->first();
        #$data = $this->createECommerceOrder($order);

        return response()->json($data);
    }

    private function convertExternalOrdersToInternalOrders($order)
    {
        try {
            return DB::transaction(function () use ($order) {

                $ticketType = DB::table('external_ticket_types')
                    ->where('name', $order->orderTicketType)
                    ->first(['name', 'slug', 'price']);

                if  (empty($ticketType))
                {
                    return 404;
                }

                $category = Category::updateOrCreate(
                    [
                        'store_id' => session('storeId'),
                        'name' => json_decode($ticketType->name, true)['tr'],
                        'slug' => $ticketType->slug,
                    ],
                    [
                        'store_id' => session('storeId'),
                        'name' => json_decode($ticketType->name, true)['tr'],
                        'slug' => $ticketType->slug,
                    ]
                );

                $ticketTime = DB::table('external_ticket_times')
                    ->where('time', $order->orderTicketBuyTime)
                    ->first();

                $productNameParts = explode(':', $ticketTime->time);
                $convertedProductName = $productNameParts[0] . ':' . $productNameParts[1];

                $product = Product::updateOrCreate(
                    [
                        'category_id' => $category->id,
                        'name' => $convertedProductName,
                        'description' => $ticketTime->time,
                        'quantity' => $ticketTime->count,
                        'price' => $ticketType->price,
                    ],
                    [
                        'category_id' => $category->id,
                        'name' => $convertedProductName,
                        'description' => $ticketTime->time,
                        'quantity' => $ticketTime->count,
                        'price' => $ticketType->price,
                    ]
                );

                $customer = Customer::updateOrCreate(
                    [
                        'email' => $order->userEmail,
                        'phone' => $order->userPhone
                    ],
                    [
                        'name' => $order->userName,
                        'surname' => $order->userSurname,
                        'email' => $order->userEmail,
                        'phone' => $order->userPhone
                    ]
                );

                $this->orderModel::updateOrCreate(
                    [
                        'customer_id' => $customer->id,
                        'quantity' => $order->orderQuantity,
                        'price' => $order->orderPrice,
                        //'status' => $order->orderStatus,
                        'is_online' => 1,
                    ],
                    [
                        'product_id' => $product->id,
                        'customer_id' => $customer->id,
                        'quantity' => $order->orderQuantity,
                        'price' => $order->orderPrice,
                        'status' => $order->orderStatus,
                        'is_online' => 1,
                    ]
                );

                return $this->orderModel::with(['product.category'])
                ->where('is_online', 1)
                ->where('store_id', session('storeId'))
                ->where('status', OrderStatus::PENDING->value)
                ->get();
            });
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function createOrder(array $data)
    {
        try {
            return DB::transaction(function () use ($data) {
                if (! session()->has('storeId')) {
                    session()->put('storeId', $data['storeId']);
                }

                $ticketTime = TicketTime::find($data['ticketTimeId']);

                $quantitySumByProductId = $this->orderRepository->getOrderQuantitySumByTicketTimeId($ticketTime->id);

                if (($quantitySumByProductId + $data['quantity']) > $ticketTime->quantity) {
                    $validator = Validator::make([], []);
                    $validator->errors()->add('quantity', 'Product quantity is not enough');
                    throw new \Illuminate\Validation\ValidationException($validator);
                }

                return $this->orderModel::create([
                    //'store_id' => $data['storeId'],
                    'ticket_time_id'    => $data['ticketTimeId'],
                    'quantity'      => $data['quantity'],
                    'price'         => floatval($ticketTime->price) * intval($data['quantity']),
                    'status'        => OrderStatus::PENDING,
                ]);
            });
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function getOrders(array $sortables = [], $paginate = 25)
    {
        return Order::with(['customers', 'ticketTime.ticket'])
            ->when($sortables, function ($query) use ($sortables) {
                foreach (array_filter($sortables) as $key => $value) {
                    $query->orderBy($key, $value);
                }
            })
            ->paginate($paginate);
    }

    public function getOrdersWithStatus($status)
    {
        return Order::with(['ticketTime.ticket'])->where('status', $status)->get();
    }
    public function deleteOrder(int $orderId)
    {
        $order = $this->orderModel::find($orderId);

        if (!$order) {
            return false;
        }

        $order->delete();

        return true;
    }
}
