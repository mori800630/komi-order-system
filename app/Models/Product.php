<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'department_id',
        'name',
        'name_kana',
        'description',
        'price',
        'status',
        'requires_packaging',
        'decoration',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'price' => 'integer',
        'requires_packaging' => 'boolean',
        'decoration' => 'string',
        'is_active' => 'boolean',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }


}
