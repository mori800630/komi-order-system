<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'name' => '注文受付',
                'code' => 'order_received',
                'sort_order' => 1,
                'description' => '注文が受付された状態',
                'is_active' => true,
            ],
            [
                'name' => '製造中',
                'code' => 'manufacturing',
                'sort_order' => 2,
                'description' => '商品の製造が進行中',
                'is_active' => true,
            ],
            [
                'name' => '梱包中',
                'code' => 'packaging',
                'sort_order' => 3,
                'description' => '商品の梱包が進行中',
                'is_active' => true,
            ],
            [
                'name' => '輸送中',
                'code' => 'in_transit',
                'sort_order' => 4,
                'description' => '商品の配送が進行中',
                'is_active' => true,
            ],
            [
                'name' => '受け渡し済み',
                'code' => 'delivered',
                'sort_order' => 5,
                'description' => '商品の受け渡しが完了',
                'is_active' => true,
            ],
        ];

        foreach ($statuses as $status) {
            OrderStatus::create($status);
        }
    }
}
