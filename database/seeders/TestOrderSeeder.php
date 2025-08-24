<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\Customer;
use App\Models\OrderDepartmentStatus;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TestOrderSeeder extends Seeder
{
    public function run(): void
    {
        // 既存の注文を削除
        Order::truncate();
        OrderItem::truncate();
        OrderDepartmentStatus::truncate();

        // ステータスIDを取得
        $orderReceived = OrderStatus::where('code', 'order_received')->first();
        $manufacturing = OrderStatus::where('code', 'manufacturing')->first();
        $packaging = OrderStatus::where('code', 'packaging')->first();
        $inTransit = OrderStatus::where('code', 'in_transit')->first();
        $delivered = OrderStatus::where('code', 'delivered')->first();

        // 商品と顧客を取得
        $products = Product::where('status', 'on_sale')->get();
        $customers = Customer::all();

        // 40件の注文を作成
        for ($i = 0; $i < 40; $i++) {
            // 注文日時を設定（古い順）
            $orderDate = Carbon::now()->subDays(40 - $i)->subHours(rand(1, 23));
            
            // 注文ステータスを決定
            if ($i < 20) {
                // 古い20件は受け渡し済み
                $orderStatus = $delivered;
            } elseif ($i < 25) {
                // 次の5件は輸送中
                $orderStatus = $inTransit;
            } elseif ($i < 30) {
                // 次の5件は梱包中
                $orderStatus = $packaging;
            } elseif ($i < 35) {
                // 次の5件は製造中
                $orderStatus = $manufacturing;
            } else {
                // 残り5件は注文受付
                $orderStatus = $orderReceived;
            }

            // 注文を作成
            $order = Order::create([
                'order_number' => 'O' . str_pad($i + 1, 6, '0', STR_PAD_LEFT),
                'customer_id' => $customers->random()->id,
                'order_status_id' => $orderStatus->id,
                'order_source' => ['phone', 'store', 'email', 'website'][rand(0, 3)],
                'delivery_method' => ['pickup', 'delivery'][rand(0, 1)],
                'total_amount' => 0,
                'requires_packaging' => rand(0, 1),
                'created_at' => $orderDate,
                'updated_at' => $orderDate,
            ]);

            // 注文商品を追加（1-3個の商品）
            $orderTotal = 0;
            $orderProducts = $products->random(rand(1, 3));
            
            foreach ($orderProducts as $product) {
                $quantity = rand(1, 3);
                $unitPrice = $product->price;
                $subtotal = $unitPrice * $quantity;
                $orderTotal += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'unit_price' => $unitPrice,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ]);

                // 製造ステータスを設定
                $department = $product->department;
                if ($department) {
                    $deptStatus = 'not_started';
                    
                    // 注文ステータスに応じて製造ステータスを設定
                    if ($orderStatus->code === 'order_received') {
                        $deptStatus = 'not_started';
                    } elseif ($orderStatus->code === 'manufacturing') {
                        $deptStatus = rand(0, 1) ? 'in_progress' : 'completed';
                    } elseif (in_array($orderStatus->code, ['packaging', 'in_transit', 'delivered'])) {
                        $deptStatus = 'completed';
                    }

                    OrderDepartmentStatus::create([
                        'order_id' => $order->id,
                        'department_id' => $department->id,
                        'status' => $deptStatus,
                        'started_at' => $deptStatus !== 'not_started' ? $orderDate->copy()->addMinutes(rand(10, 60)) : null,
                        'completed_at' => $deptStatus === 'completed' ? $orderDate->copy()->addHours(rand(1, 4)) : null,
                    ]);
                }
            }

            // 注文の合計金額を更新
            $order->update(['total_amount' => $orderTotal]);
        }

        echo "40件のテスト用注文データを作成しました。" . PHP_EOL;
    }
}
