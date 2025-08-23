<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model
{
    protected $fillable = [
        'order_id',
        'order_status_id',
        'user_id',
        'notes',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
