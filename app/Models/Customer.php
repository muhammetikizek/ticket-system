<?php

namespace App\Models;

class Customer extends BaseModel
{

    protected $table = 'customers';

    protected $fillable = [
        'name',
        'surname',
        'email',
        'phone',
        'address',
    ];

    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    public function getSurnameAttribute($value)
    {
        return ucwords($value);
    }

    public function orderTicket()
    {
        return $this->belongsToMany(OrderTicket::class, 'order_ticket_customer', 'customer_id', 'order_ticket_id');
    }
}
