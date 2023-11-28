<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $table = 'products';

    protected $fillable = [
        'name',
        'code',
        'sku',
        'quantity',
        'price',
        'type',
        'enabled',
        'category_id',
        'description',
        'currency'
    ];

    protected $casts = [
        'price' => 'float',
        'quantity' => 'integer',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    private function getTotalQuantityAttribute()
    {
        return $this->orders()->where('status', 'Pending')->sum('quantity');
    }

    public function getRemainingQuantityAttribute()
    {
        return $this->quantity - $this->getTotalQuantityAttribute();
    }

    public function getPriceAttribute($value)
    {
        return number_format($value, 2, ',', '.');
    }

    public function getCurrencyAttribute($value)
    {
        return $value === 'TRY' ? 'TL' : $value;
    }
}
