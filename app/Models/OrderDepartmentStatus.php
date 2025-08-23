<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDepartmentStatus extends Model
{
    protected $fillable = [
        'order_id',
        'department_id',
        'status',
        'user_id',
        'started_at',
        'completed_at',
        'notes',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusTextAttribute()
    {
        return [
            'not_started' => '未開始',
            'in_progress' => '製造中',
            'completed' => '製造完了',
        ][$this->status] ?? '不明';
    }

    public function getStatusBadgeClassAttribute()
    {
        return [
            'not_started' => 'bg-secondary',
            'in_progress' => 'bg-warning',
            'completed' => 'bg-success',
        ][$this->status] ?? 'bg-secondary';
    }
}
