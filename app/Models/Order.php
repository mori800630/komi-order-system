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

    protected static $rules = [
        'order_source' => 'in:phone,store,pickup_site,delivery_site,email,event,other',
        'delivery_method' => 'in:pickup,delivery',
    ];

    protected $attributes = [
        'order_source' => 'phone',
        'delivery_method' => 'pickup',
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

    public function departmentStatuses()
    {
        return $this->hasMany(OrderDepartmentStatus::class);
    }

    public function getAvailableTransitions($user)
    {
        return OrderStatusTransition::where('from_status_id', $this->order_status_id)
            ->where('is_active', true)
            ->get()
            ->filter(function ($transition) use ($user) {
                return $transition->canTransition($user, $this);
            });
    }

    public function getAllAvailableTransitions()
    {
        return OrderStatusTransition::where('from_status_id', $this->order_status_id)
            ->where('is_active', true)
            ->get();
    }

    public function canTransitionTo($toStatusId, $user)
    {
        $transition = OrderStatusTransition::where('from_status_id', $this->order_status_id)
            ->where('to_status_id', $toStatusId)
            ->where('is_active', true)
            ->first();

        return $transition && $transition->canTransition($user, $this);
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

            // order_sourceの値を検証
            $validOrderSources = ['phone', 'store', 'pickup_site', 'delivery_site', 'email', 'event', 'other', 'website'];
            if (!in_array($order->order_source, $validOrderSources)) {
                throw new \InvalidArgumentException('Invalid order_source value: ' . $order->order_source);
            }

            // delivery_methodの値を検証
            $validDeliveryMethods = ['pickup', 'delivery'];
            if (!in_array($order->delivery_method, $validDeliveryMethods)) {
                throw new \InvalidArgumentException('Invalid delivery_method value: ' . $order->delivery_method);
            }
        });

        static::created(function ($order) {
            // 注文作成時に部門別ステータスを初期化
            $order->load('orderItems.product.department');
            $departments = $order->orderItems->pluck('product.department')->unique();
            
            foreach ($departments as $department) {
                $order->departmentStatuses()->create([
                    'department_id' => $department->id,
                    'status' => 'not_started',
                    'user_id' => auth()->id(),
                ]);
            }
        });
    }

    public function updateTotalAmount()
    {
        $this->total_amount = $this->orderItems->sum('subtotal');
        $this->save();
    }
}
