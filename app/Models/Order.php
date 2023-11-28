<?php

namespace App\Models;


class Order extends BaseModel
{

    protected $table = 'orders';

    protected $fillable = [
        'store_id',
        'order_number',
        'quantity',
        'total_price',
        'status'
    ];

    protected $casts = [
        'price' => 'decimal',
        'quantity' => 'integer',
    ];

    public function ticketTime()
    {
        return $this->belongsTo(TicketTime::class);
    }

    /**
     * The customers that belong to the order.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'order_customer', 'order_id', 'customer_id');
    }

    public function scopeIsOnline($query)
    {
        return $query->where('is_online', 1);
    }

    public function scopeOnsite($query)
    {
        return $query->where('is_online', 0);
    }

    protected static function booted()
    {
        static::creating(function ($order) {
            $order->store_id = session('storeId');
            $order->order_number = time();
        });
    }

    public function getPriceAttribute($value)
    {
        return number_format($value, 2);
    }
}
