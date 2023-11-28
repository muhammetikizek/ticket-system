<?php

namespace App\Models;

use App\Models\BaseModel;

class TicketTime extends BaseModel
{

    protected $table = 'ticket_times';

    protected $fillable = [
        'ticket_id',
        'name',
        'description',
        'time',
        'quantity',
        'price',
        'currency',
        'enabled'
    ];

    protected $casts = [
        'price' => 'float',
        'quantity' => 'integer',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function orderTickets()
    {
        return $this->hasMany(OrderTicket::class);
    }

    private function getTotalQuantityAttribute()
    {
        return $this->orderTickets()->where('status', 'pending')->sum('quantity');
    }

    public function getRemainingQuantityAttribute()
    {
        return $this->quantity - $this->getTotalQuantityAttribute();
    }

    public function getPriceAttribute($value)
    {
        return number_format($value, 2, ',', '.');
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = str_replace(',', '.', $value);
    }

    public function getCurrencyAttribute($value)
    {
        return $value === 'TRY' ? 'TL' : $value;
    }
}
