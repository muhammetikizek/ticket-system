<?php


namespace App\Services;
use App\Repositories\OrderRepository;


class OrderSearchService
{
    public OrderRepository $orderRepository;

    public function __construct(
        public ?int $orderId,
        public ?string $customerName,
        public ?string $customerSurname,
        public ?string $customerEmail,
    )
    {
    }

    public function getOnlineOrder()
    {
        return $this->orderRepository->getOnlineOrderCount();
    }


}
