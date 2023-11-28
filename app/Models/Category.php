<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $table = 'categories';

    protected $fillable = [
        'store_id',
        'parent_id',
        'name',
        'slug',
        'description',
        'enabled',
    ];

    public function scopeEnabled($query)
    {
        return $query->where('enabled', true);
    }
}
