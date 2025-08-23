<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatusTransition extends Model
{
    protected $fillable = [
        'from_status_id',
        'to_status_id',
        'required_role',
        'requires_all_departments_completed',
        'description',
        'is_active',
    ];

    protected $casts = [
        'requires_all_departments_completed' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function fromStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'from_status_id');
    }

    public function toStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'to_status_id');
    }

    public function canTransition($user, $order = null)
    {
        // 管理者は全ての遷移が可能
        if ($user->isAdmin()) {
            return true;
        }

        // ロールチェック
        if ($this->required_role && $user->role !== $this->required_role) {
            return false;
        }

        // 全部門完了が必要な場合のチェック
        if ($this->requires_all_departments_completed && $order) {
            $orderItems = $order->orderItems;
            $departments = $orderItems->pluck('product.department_id')->unique();
            
            foreach ($departments as $departmentId) {
                $deptStatus = $order->departmentStatuses()
                    ->where('department_id', $departmentId)
                    ->first();
                
                if (!$deptStatus || $deptStatus->status !== 'completed') {
                    return false;
                }
            }
        }

        return true;
    }
}
