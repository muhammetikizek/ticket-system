<?php

namespace App\Services;

use App\Enums\OrderStatus;
use Illuminate\Support\Facades\DB;

class DashboardService extends WidgetBaseService
{

    private static string $currency = '₺';

    public string $title;

    public string $description;

    public string $icon;

    public function widget()
    {
        $this->getTotalOnlineOrderCount();
        return $this;
    }

    public function getTodayOrderCount()
    {
        $this->title = 'Günlük Sipariş Sayısı';
        return $this->setNumberFormat(
            $this->getOrders()
            ->whereDate('created_at', today())
            ->where('status', OrderStatus::COMPLETED->value)
            ->count()
        );
    }

    public function getTotalOnlineOrderCount()
    {
        $this->title = 'Toplam Online Bilet Satışı';
        return $this->setNumberFormat($this->getOrderTickets()->where('is_online', true)->count());
    }

    public function getTotalCustomerCount()
    {
        return $this->setNumberFormat($this->getCustomers()->count());
    }

    public function getTotalOrderCount()
    {
        return $this->setNumberFormat($this->getOrders()->count());
    }

    public function getTotalOrderPrice()
    {
        $price = $this->setMoneyFormat($this->getOrderTickets()->sum('price'));
        $price .= self::$currency;
        return $price;
    }



}

abstract class WidgetBaseService
{
    abstract public function widget();

    protected function setMoneyFormat($money)
    {
        return number_format($money, 2, ',', '.');
    }

    protected function setNumberFormat($number)
    {
        return number_format($number, 0, ',', '.');
    }

    protected function getCustomers()
    {
        return DB::table('customers');
    }
    public function getOrders()
    {
        return DB::table('orders');
    }

    protected function getTickets()
    {
        return DB::table('tickets');
    }

    protected function getOrderTickets()
    {
        return DB::table('order_tickets');
    }
}
