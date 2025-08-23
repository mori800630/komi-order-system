<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'customer_id',
        'order_status_id',
        'order_source',
        'delivery_method',
        'total_amount',
        'pickup_date',
        'pickup_time',
        'notes',
        'requires_packaging',
    ];

    protected $casts = [
        'total_amount' => 'integer',
        'pickup_date' => 'date',
        'pickup_time' => 'datetime:H:i',
        'requires_packaging' => 'boolean',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderStatusHistories()
    {
        return $this->hasMany(OrderStatusHistory::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $lastOrder = self::orderBy('id', 'desc')->first();
                $lastNumber = $lastOrder ? intval(substr($lastOrder->order_number, 1)) : 0;
                $order->order_number = 'O' . str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
            }
        });
    }

    public function updateTotalAmount()
    {
        $this->total_amount = $this->orderItems->sum('subtotal');
        $this->save();
    }
}
