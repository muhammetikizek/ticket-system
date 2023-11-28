<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{

    protected $table = 'tickets';

    protected $fillable = [
        'store_id',
        'name',
        'slug',
        'description',
        'price',
        'quantity',
        'enabled',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function times()
    {
        return $this->hasMany(TicketTime::class);
    }

    public function getNameAttribute($value)
    {
        return Str::title($value);
    }
}
