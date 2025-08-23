<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use App\Models\OrderStatusTransition;
use Illuminate\Database\Seeder;

class OrderStatusTransitionSeeder extends Seeder
{
    public function run(): void
    {
        // ステータスIDを取得
        $orderReceived = OrderStatus::where('code', 'order_received')->first();
        $manufacturing = OrderStatus::where('code', 'manufacturing')->first();
        $packaging = OrderStatus::where('code', 'packaging')->first();
        $inTransit = OrderStatus::where('code', 'in_transit')->first();
        $delivered = OrderStatus::where('code', 'delivered')->first();

        // 遷移ルールを定義
        $transitions = [
            // 注文受付 → 製造中（店舗スタッフまたは管理者）
            [
                'from_status_id' => $orderReceived->id,
                'to_status_id' => $manufacturing->id,
                'required_role' => 'store',
                'requires_all_departments_completed' => false,
                'description' => '店舗スタッフが注文を製造部門に引き渡し',
            ],
            
            // 製造中 → 梱包中（製造部門または管理者、全部門完了が必要）
            [
                'from_status_id' => $manufacturing->id,
                'to_status_id' => $packaging->id,
                'required_role' => 'manufacturing',
                'requires_all_departments_completed' => true,
                'description' => '全製造部門の作業が完了',
            ],
            
            // 梱包中 → 輸送中（物流部門または管理者）
            [
                'from_status_id' => $packaging->id,
                'to_status_id' => $inTransit->id,
                'required_role' => 'logistics',
                'requires_all_departments_completed' => false,
                'description' => '物流部門が配送を開始',
            ],
            
            // 輸送中 → 受け渡し済み（物流部門または管理者）
            [
                'from_status_id' => $inTransit->id,
                'to_status_id' => $delivered->id,
                'required_role' => 'logistics',
                'requires_all_departments_completed' => false,
                'description' => '配送完了・受け渡し済み',
            ],
        ];

        foreach ($transitions as $transition) {
            OrderStatusTransition::create($transition);
        }
    }
}
