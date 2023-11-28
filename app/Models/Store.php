<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $table = 'stores';

    protected $fillable = [
        'name',
        'branch_name',
    ];

    public function scopeEnabled(Builder $query): void
    {
        $query->where('enabled', '=', true);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'store_users', 'store_id', 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'store_id', 'id');
    }
}
