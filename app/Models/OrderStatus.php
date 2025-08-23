<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $fillable = [
        'name',
        'code',
        'sort_order',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function orderStatusHistories()
    {
        return $this->hasMany(OrderStatusHistory::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
