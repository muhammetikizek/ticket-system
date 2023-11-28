<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Support\Str;

class OrderTicket extends BaseModel
{

    protected $table = 'order_tickets';

    protected $fillable = [
        'order_id',
        'ticket_time_id',
        'code',
        'quantity',
        'price',
        'is_online',
        'status',
    ];

    protected $casts = [
        'is_online' => 'boolean',
        'price' => 'float',
        'quantity' => 'integer',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }


    public function ticketTime()
    {
        return $this->belongsTo(TicketTime::class);
    }

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'order_ticket_customer', 'order_ticket_id', 'customer_id');
    }

    protected static function booted()
    {
        static::creating(function ($orderTicket) {
            $orderTicket->code = static::generateTicketCode();
        });
    }

    protected static function generateTicketCode(string $prefix = 'TCK-')
    {
        $code = $prefix;
        $code .= Str::upper(Str::random(8));
        return $code;
    }

    public function getStatusAttribute($value)
    {
        return Str::ucfirst($value);
    }

    public function getIsOnlineAttribute($value)
    {
        return $value ? 'Online' : 'Gişe';
    }

    public function getQuantityAttribute($value)
    {
        return number_format($value, 0, ',', '.');
    }

    public function getCurrencyAttribute($value)
    {
        return $value === 'TRY' ? 'TL' : $value;
    }
}
