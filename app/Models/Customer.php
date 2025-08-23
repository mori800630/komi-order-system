<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'customer_number',
        'name',
        'email',
        'phone',
        'postal_code',
        'prefecture',
        'address',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($customer) {
            if (empty($customer->customer_number)) {
                $lastCustomer = self::orderBy('id', 'desc')->first();
                $lastNumber = $lastCustomer ? intval(substr($lastCustomer->customer_number, 1)) : 0;
                $customer->customer_number = 'C' . str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
            }
        });
    }
}
