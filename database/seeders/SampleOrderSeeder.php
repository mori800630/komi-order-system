<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\OrderDepartmentStatus;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SampleOrderSeeder extends Seeder
{
    public function run(): void
    {
        // 既存の注文データをクリア
        OrderDepartmentStatus::truncate();
        OrderItem::truncate();
        Order::truncate();

        // ステータスを取得
        $orderReceived = OrderStatus::where('code', 'order_received')->first();
        $manufacturing = OrderStatus::where('code', 'manufacturing')->first();
        $packaging = OrderStatus::where('code', 'packaging')->first();
        $inTransit = OrderStatus::where('code', 'in_transit')->first();
        $delivered = OrderStatus::where('code', 'delivered')->first();

        // 部門を取得
        $westernDept = Department::where('name', '洋菓子製造部')->first();
        $sandwichDept = Department::where('name', 'サンドイッチ製造部')->first();
        $breadDept = Department::where('name', 'パン製造部')->first();
        $cheesecakeMainDept = Department::where('name', 'チーズケーキ製造部(本店)')->first();
        $cheesecakeNangokuDept = Department::where('name', 'チーズケーキ製造部(南国店)')->first();

        // 顧客を取得（最初の10件）
        $customers = Customer::take(10)->get();

        // 商品を取得（販売中のもの）
        $products = Product::where('status', 'on_sale')->get();

        // 部門別に商品を取得
        $westernProducts = $products->where('department_id', $westernDept->id);
        $sandwichProducts = $products->where('department_id', $sandwichDept->id);
        $breadProducts = $products->where('department_id', $breadDept->id);
        $cheesecakeMainProducts = $products->where('department_id', $cheesecakeMainDept->id);
        $cheesecakeNangokuProducts = $products->where('department_id', $cheesecakeNangokuDept->id);

        // 製造部門ユーザーを取得
        $manufacturingUsers = User::where('role', 'manufacturing')->get();

        // 10件の注文データを作成
        $orders = [
            // 1. 注文受付状態（製造ステータス：未開始）
            [
                'customer' => $customers[0],
                'order_status' => $orderReceived,
                'total_amount' => 3500,
                'created_at' => Carbon::now()->subDays(5)->setTime(9, 30),
                'items' => [
                    ['product' => $westernProducts->first(), 'quantity' => 1, 'unit_price' => 3500],
                ],
                'department_statuses' => [
                    ['department' => $westernDept, 'status' => 'not_started', 'user' => null],
                ]
            ],

            // 2. 製造中状態（製造ステータス：製造中）
            [
                'customer' => $customers[1],
                'order_status' => $manufacturing,
                'total_amount' => 4200,
                'created_at' => Carbon::now()->subDays(4)->setTime(10, 15),
                'items' => [
                    ['product' => $sandwichProducts->first(), 'quantity' => 2, 'unit_price' => 2100],
                ],
                'department_statuses' => [
                    ['department' => $sandwichDept, 'status' => 'in_progress', 'user' => $manufacturingUsers->first(), 'started_at' => Carbon::now()->subDays(3)->setTime(8, 0)],
                ]
            ],

            // 3. 製造中状態（製造ステータス：製造完了）
            [
                'customer' => $customers[2],
                'order_status' => $manufacturing,
                'total_amount' => 2800,
                'created_at' => Carbon::now()->subDays(3)->setTime(14, 20),
                'items' => [
                    ['product' => $breadProducts->first(), 'quantity' => 1, 'unit_price' => 2800],
                ],
                'department_statuses' => [
                    ['department' => $breadDept, 'status' => 'completed', 'user' => $manufacturingUsers->first(), 'started_at' => Carbon::now()->subDays(2)->setTime(7, 30), 'completed_at' => Carbon::now()->subDays(1)->setTime(16, 0)],
                ]
            ],

            // 4. 梱包中状態（製造ステータス：製造完了）
            [
                'customer' => $customers[3],
                'order_status' => $packaging,
                'total_amount' => 6500,
                'created_at' => Carbon::now()->subDays(2)->setTime(11, 45),
                'items' => [
                    ['product' => $westernProducts->first(), 'quantity' => 1, 'unit_price' => 3500],
                    ['product' => $cheesecakeMainProducts->first(), 'quantity' => 1, 'unit_price' => 3000],
                ],
                'department_statuses' => [
                    ['department' => $westernDept, 'status' => 'completed', 'user' => $manufacturingUsers->first(), 'started_at' => Carbon::now()->subDays(1)->setTime(8, 0), 'completed_at' => Carbon::now()->setTime(12, 0)],
                    ['department' => $cheesecakeMainDept, 'status' => 'completed', 'user' => $manufacturingUsers->first(), 'started_at' => Carbon::now()->subDays(1)->setTime(8, 0), 'completed_at' => Carbon::now()->setTime(11, 30)],
                ]
            ],

            // 5. 輸送中状態（製造ステータス：製造完了）
            [
                'customer' => $customers[4],
                'order_status' => $inTransit,
                'total_amount' => 1800,
                'created_at' => Carbon::now()->subDays(1)->setTime(16, 30),
                'items' => [
                    ['product' => $sandwichProducts->first(), 'quantity' => 1, 'unit_price' => 1800],
                ],
                'department_statuses' => [
                    ['department' => $sandwichDept, 'status' => 'completed', 'user' => $manufacturingUsers->first(), 'started_at' => Carbon::now()->subDays(1)->setTime(7, 0), 'completed_at' => Carbon::now()->setTime(15, 0)],
                ]
            ],

            // 6. 受け渡し済み状態（製造ステータス：製造完了）
            [
                'customer' => $customers[5],
                'order_status' => $delivered,
                'total_amount' => 5200,
                'created_at' => Carbon::now()->subDays(1)->setTime(9, 0),
                'items' => [
                    ['product' => $westernProducts->first(), 'quantity' => 1, 'unit_price' => 3500],
                    ['product' => $breadProducts->first(), 'quantity' => 1, 'unit_price' => 1700],
                ],
                'department_statuses' => [
                    ['department' => $westernDept, 'status' => 'completed', 'user' => $manufacturingUsers->first(), 'started_at' => Carbon::now()->subDays(1)->setTime(7, 0), 'completed_at' => Carbon::now()->subDays(1)->setTime(14, 0)],
                    ['department' => $breadDept, 'status' => 'completed', 'user' => $manufacturingUsers->first(), 'started_at' => Carbon::now()->subDays(1)->setTime(7, 0), 'completed_at' => Carbon::now()->subDays(1)->setTime(13, 30)],
                ]
            ],

            // 7. 注文受付状態（製造ステータス：未開始）
            [
                'customer' => $customers[6],
                'order_status' => $orderReceived,
                'total_amount' => 4500,
                'created_at' => Carbon::now()->subHours(2)->setTime(13, 15),
                'items' => [
                    ['product' => $cheesecakeNangokuProducts->first(), 'quantity' => 1, 'unit_price' => 4500],
                ],
                'department_statuses' => [
                    ['department' => $cheesecakeNangokuDept, 'status' => 'not_started', 'user' => null],
                ]
            ],

            // 8. 製造中状態（製造ステータス：製造中）
            [
                'customer' => $customers[7],
                'order_status' => $manufacturing,
                'total_amount' => 3800,
                'created_at' => Carbon::now()->subHours(4)->setTime(10, 45),
                'items' => [
                    ['product' => $westernProducts->first(), 'quantity' => 1, 'unit_price' => 3500],
                    ['product' => $sandwichProducts->first(), 'quantity' => 1, 'unit_price' => 300],
                ],
                'department_statuses' => [
                    ['department' => $westernDept, 'status' => 'in_progress', 'user' => $manufacturingUsers->first(), 'started_at' => Carbon::now()->subHours(3)->setTime(8, 0)],
                    ['department' => $sandwichDept, 'status' => 'in_progress', 'user' => $manufacturingUsers->first(), 'started_at' => Carbon::now()->subHours(2)->setTime(9, 0)],
                ]
            ],

            // 9. 梱包中状態（製造ステータス：製造完了）
            [
                'customer' => $customers[8],
                'order_status' => $packaging,
                'total_amount' => 7200,
                'created_at' => Carbon::now()->subHours(6)->setTime(8, 30),
                'items' => [
                    ['product' => $westernProducts->first(), 'quantity' => 1, 'unit_price' => 3500],
                    ['product' => $cheesecakeMainProducts->first(), 'quantity' => 1, 'unit_price' => 3000],
                    ['product' => $breadProducts->first(), 'quantity' => 1, 'unit_price' => 700],
                ],
                'department_statuses' => [
                    ['department' => $westernDept, 'status' => 'completed', 'user' => $manufacturingUsers->first(), 'started_at' => Carbon::now()->subHours(5)->setTime(7, 0), 'completed_at' => Carbon::now()->subHours(1)->setTime(12, 0)],
                    ['department' => $cheesecakeMainDept, 'status' => 'completed', 'user' => $manufacturingUsers->first(), 'started_at' => Carbon::now()->subHours(5)->setTime(7, 0), 'completed_at' => Carbon::now()->subHours(1)->setTime(11, 30)],
                    ['department' => $breadDept, 'status' => 'completed', 'user' => $manufacturingUsers->first(), 'started_at' => Carbon::now()->subHours(5)->setTime(7, 0), 'completed_at' => Carbon::now()->subHours(1)->setTime(11, 0)],
                ]
            ],

            // 10. 受け渡し済み状態（製造ステータス：製造完了）
            [
                'customer' => $customers[9],
                'order_status' => $delivered,
                'total_amount' => 2500,
                'created_at' => Carbon::now()->subDays(2)->setTime(15, 20),
                'items' => [
                    ['product' => $breadProducts->first(), 'quantity' => 1, 'unit_price' => 2500],
                ],
                'department_statuses' => [
                    ['department' => $breadDept, 'status' => 'completed', 'user' => $manufacturingUsers->first(), 'started_at' => Carbon::now()->subDays(2)->setTime(7, 0), 'completed_at' => Carbon::now()->subDays(1)->setTime(16, 0)],
                ]
            ],
        ];

        foreach ($orders as $orderData) {
            // 商品が存在するかチェック
            $validItems = [];
            foreach ($orderData['items'] as $itemData) {
                if ($itemData['product']) {
                    $validItems[] = $itemData;
                }
            }

            if (empty($validItems)) {
                continue; // 商品が存在しない場合はスキップ
            }

            // 注文を作成
            $order = Order::create([
                'customer_id' => $orderData['customer']->id,
                'order_status_id' => $orderData['order_status']->id,
                'order_source' => ['phone', 'store', 'email', 'pickup_site'][array_rand(['phone', 'store', 'email', 'pickup_site'])],
                'delivery_method' => ['pickup', 'delivery'][array_rand(['pickup', 'delivery'])],
                'total_amount' => $orderData['total_amount'],
                'pickup_date' => Carbon::now()->addDays(rand(1, 7)),
                'pickup_time' => Carbon::now()->setTime(rand(9, 18), 0),
                'notes' => 'サンプル注文データ',
                'requires_packaging' => rand(0, 1),
                'created_at' => $orderData['created_at'],
                'updated_at' => $orderData['created_at'],
            ]);

            // 注文アイテムを作成
            foreach ($validItems as $itemData) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $itemData['product']->id,
                    'quantity' => $itemData['quantity'],
                    'unit_price' => $itemData['unit_price'],
                    'subtotal' => $itemData['quantity'] * $itemData['unit_price'],
                ]);
            }

            // 部門別製造ステータスを作成
            foreach ($orderData['department_statuses'] as $deptStatusData) {
                OrderDepartmentStatus::create([
                    'order_id' => $order->id,
                    'department_id' => $deptStatusData['department']->id,
                    'status' => $deptStatusData['status'],
                    'user_id' => $deptStatusData['user'] ? $deptStatusData['user']->id : null,
                    'started_at' => $deptStatusData['started_at'] ?? null,
                    'completed_at' => $deptStatusData['completed_at'] ?? null,
                    'notes' => 'サンプルデータ',
                ]);
            }
        }

        echo "10件のサンプル注文データを作成しました。" . PHP_EOL;
        echo "ステータスと製造ステータスの整合性を保ったデータです。" . PHP_EOL;
    }
}
