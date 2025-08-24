<?php

namespace App\Rules;

use App\Models\Order;
use App\Models\OrderStatus;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AllDepartmentsCompleted implements ValidationRule
{
    protected $order;
    protected $currentStatusId;

    public function __construct(Order $order, $currentStatusId)
    {
        $this->order = $order;
        $this->currentStatusId = $currentStatusId;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // 梱包中ステータスを取得
        $packagingStatus = OrderStatus::where('code', 'packaging')->first();
        
        // 梱包中に変更しようとしている場合のみチェック
        if ($value == $packagingStatus->id) {
            // orderItemsとproduct.departmentを確実にロード
            $this->order->load('orderItems.product.department');
            
            $departments = $this->order->orderItems->pluck('product.department')->unique();
            $incompleteDepartments = collect();
            
            foreach ($departments as $department) {
                $deptStatus = $this->order->departmentStatuses()
                    ->where('department_id', $department->id)
                    ->first();
                
                if (!$deptStatus || $deptStatus->status !== 'completed') {
                    $incompleteDepartments->push($department->name);
                }
            }
            
            if ($incompleteDepartments->count() > 0) {
                $fail("梱包中に変更するには、全製造部門の作業が完了している必要があります。未完了の部門: " . $incompleteDepartments->implode(', '));
            }
        }
    }
}
