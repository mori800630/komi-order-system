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

class AdditionalDeliveredOrderSeeder extends Seeder
{
    public function run(): void
    {
        // ステータスを取得
        $delivered = OrderStatus::where('code', 'delivered')->first();

        // 部門を取得
        $westernDept = Department::where('name', '洋菓子製造部')->first();
        $sandwichDept = Department::where('name', 'サンドイッチ製造部')->first();
        $breadDept = Department::where('name', 'パン製造部')->first();
        $cheesecakeMainDept = Department::where('name', 'チーズケーキ製造部(本店)')->first();
        $cheesecakeNangokuDept = Department::where('name', 'チーズケーキ製造部(南国店)')->first();

        // 顧客を取得（11番目から20番目）
        $customers = Customer::skip(10)->take(10)->get();

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

        // 10件の受け渡し済み注文データを作成
        $orders = [
            // 1. 古い受け渡し済み注文（1ヶ月前）
            [
                'customer' => $customers[0],
                'order_status' => $delivered,
                'total_amount' => 4200,
                'created_at' => Carbon::now()->subMonth()->subDays(5)->setTime(9, 15),
                'delivered_at' => Carbon::now()->subMonth()->subDays(3)->setTime(14, 30),
                'items' => [
                    ['product' => $westernProducts->first(), 'quantity' => 1, 'unit_price' => 3500],
                    ['product' => $sandwichProducts->first(), 'quantity' => 1, 'unit_price' => 700],
                ],
                'department_statuses' => [
                    ['department' => $westernDept, 'status' => 'completed', 'user' => $manufacturingUsers->first(), 'started_at' => Carbon::now()->subMonth()->subDays(4)->setTime(7, 0), 'completed_at' => Carbon::now()->subMonth()->subDays(3)->setTime(12, 0)],
                    ['department' => $sandwichDept, 'status' => 'completed', 'user' => $manufacturingUsers->first(), 'started_at' => Carbon::now()->subMonth()->subDays(4)->setTime(7, 0), 'completed_at' => Carbon::now()->subMonth()->subDays(3)->setTime(11, 30)],
                ]
            ],

            // 2. 古い受け渡し済み注文（3週間前）
            [
                'customer' => $customers[1],
                'order_status' => $delivered,
                'total_amount' => 5800,
                'created_at' => Carbon::now()->subWeeks(3)->subDays(2)->setTime(11, 45),
                'delivered_at' => Carbon::now()->subWeeks(3)->setTime(16, 15),
                'items' => [
                    ['product' => $cheesecakeMainProducts->first(), 'quantity' => 1, 'unit_price' => 3000],
                    ['product' => $breadProducts->first(), 'quantity' => 1, 'unit_price' => 2800],
                ],
                'department_statuses' => [
                    ['department' => $cheesecakeMainDept, 'status' => 'completed', 'user' => $manufacturingUsers->first(), 'started_at' => Carbon::now()->subWeeks(3)->subDays(1)->setTime(8, 0), 'completed_at' => Carbon::now()->subWeeks(3)->setTime(14, 0)],
                    ['department' => $breadDept, 'status' => 'completed', 'user' => $manufacturingUsers->first(), 'started_at' => Carbon::now()->subWeeks(3)->subDays(1)->setTime(8, 0), 'completed_at' => Carbon::now()->subWeeks(3)->setTime(13, 30)],
                ]
            ],

            // 3. 古い受け渡し済み注文（2週間前）
            [
                'customer' => $customers[2],
                'order_status' => $delivered,
                'total_amount' => 3200,
                'created_at' => Carbon::now()->subWeeks(2)->subDays(3)->setTime(14, 20),
                'delivered_at' => Carbon::now()->subWeeks(2)->subDays(1)->setTime(10, 45),
                'items' => [
                    ['product' => $sandwichProducts->first(), 'quantity' => 2, 'unit_price' => 1600],
                ],
                'department_statuses' => [
                    ['department' => $sandwichDept, 'status' => 'completed', 'user' => $manufacturingUsers->first(), 'started_at' => Carbon::now()->subWeeks(2)->subDays(2)->setTime(7, 0), 'completed_at' => Carbon::now()->subWeeks(2)->subDays(1)->setTime(9, 0)],
                ]
            ],

            // 4. 古い受け渡し済み注文（10日前）
            [
                'customer' => $customers[3],
                'order_status' => $delivered,
                'total_amount' => 7500,
                'created_at' => Carbon::now()->subDays(12)->setTime(16, 30),
                'delivered_at' => Carbon::now()->subDays(10)->setTime(15, 20),
                'items' => [
                    ['product' => $westernProducts->first(), 'quantity' => 1, 'unit_price' => 3500],
                    ['product' => $cheesecakeNangokuProducts->first(), 'quantity' => 1, 'unit_price' => 4000],
                ],
                'department_statuses' => [
                    ['department' => $westernDept, 'status' => 'completed', 'user' => $manufacturingUsers->first(), 'started_at' => Carbon::now()->subDays(11)->setTime(8, 0), 'completed_at' => Carbon::now()->subDays(10)->setTime(13, 0)],
                    ['department' => $cheesecakeNangokuDept, 'status' => 'completed', 'user' => $manufacturingUsers->first(), 'started_at' => Carbon::now()->subDays(11)->setTime(8, 0), 'completed_at' => Carbon::now()->subDays(10)->setTime(12, 30)],
                ]
            ],

            // 5. 古い受け渡し済み注文（8日前）
            [
                'customer' => $customers[4],
                'order_status' => $delivered,
                'total_amount' => 1900,
                'created_at' => Carbon::now()->subDays(10)->setTime(8, 45),
                'delivered_at' => Carbon::now()->subDays(8)->setTime(11, 30),
                'items' => [
                    ['product' => $breadProducts->first(), 'quantity' => 1, 'unit_price' => 1900],
                ],
                'department_statuses' => [
                    ['department' => $breadDept, 'status' => 'completed', 'user' => $manufacturingUsers->first(), 'started_at' => Carbon::now()->subDays(9)->setTime(7, 0), 'completed_at' => Carbon::now()->subDays(8)->setTime(10, 0)],
                ]
            ],

            // 6. 古い受け渡し済み注文（6日前）
            [
                'customer' => $customers[5],
                'order_status' => $delivered,
                'total_amount' => 6300,
                'created_at' => Carbon::now()->subDays(8)->setTime(13, 15),
                'delivered_at' => Carbon::now()->subDays(6)->setTime(17, 45),
                'items' => [
                    ['product' => $westernProducts->first(), 'quantity' => 1, 'unit_price' => 3500],
                    ['product' => $cheesecakeMainProducts->first(), 'quantity' => 1, 'unit_price' => 2800],
                ],
                'department_statuses' => [
                    ['department' => $westernDept, 'status' => 'completed', 'user' => $manufacturingUsers->first(), 'started_at' => Carbon::now()->subDays(7)->setTime(8, 0), 'completed_at' => Carbon::now()->subDays(6)->setTime(15, 0)],
                    ['department' => $cheesecakeMainDept, 'status' => 'completed', 'user' => $manufacturingUsers->first(), 'started_at' => Carbon::now()->subDays(7)->setTime(8, 0), 'completed_at' => Carbon::now()->subDays(6)->setTime(14, 30)],
                ]
            ],

            // 7. 古い受け渡し済み注文（5日前）
            [
                'customer' => $customers[6],
                'order_status' => $delivered,
                'total_amount' => 4100,
                'created_at' => Carbon::now()->subDays(7)->setTime(10, 30),
                'delivered_at' => Carbon::now()->subDays(5)->setTime(14, 15),
                'items' => [
                    ['product' => $sandwichProducts->first(), 'quantity' => 1, 'unit_price' => 1800],
                    ['product' => $breadProducts->first(), 'quantity' => 1, 'unit_price' => 2300],
                ],
                'department_statuses' => [
                    ['department' => $sandwichDept, 'status' => 'completed', 'user' => $manufacturingUsers->first(), 'started_at' => Carbon::now()->subDays(6)->setTime(7, 0), 'completed_at' => Carbon::now()->subDays(5)->setTime(12, 0)],
                    ['department' => $breadDept, 'status' => 'completed', 'user' => $manufacturingUsers->first(), 'started_at' => Carbon::now()->subDays(6)->setTime(7, 0), 'completed_at' => Carbon::now()->subDays(5)->setTime(11, 30)],
                ]
            ],

            // 8. 古い受け渡し済み注文（4日前）
            [
                'customer' => $customers[7],
                'order_status' => $delivered,
                'total_amount' => 5200,
                'created_at' => Carbon::now()->subDays(6)->setTime(15, 45),
                'delivered_at' => Carbon::now()->subDays(4)->setTime(16, 30),
                'items' => [
                    ['product' => $cheesecakeNangokuProducts->first(), 'quantity' => 1, 'unit_price' => 4500],
                    ['product' => $sandwichProducts->first(), 'quantity' => 1, 'unit_price' => 700],
                ],
                'department_statuses' => [
                    ['department' => $cheesecakeNangokuDept, 'status' => 'completed', 'user' => $manufacturingUsers->first(), 'started_at' => Carbon::now()->subDays(5)->setTime(8, 0), 'completed_at' => Carbon::now()->subDays(4)->setTime(14, 0)],
                    ['department' => $sandwichDept, 'status' => 'completed', 'user' => $manufacturingUsers->first(), 'started_at' => Carbon::now()->subDays(5)->setTime(8, 0), 'completed_at' => Carbon::now()->subDays(4)->setTime(13, 30)],
                ]
            ],

            // 9. 古い受け渡し済み注文（3日前）
            [
                'customer' => $customers[8],
                'order_status' => $delivered,
                'total_amount' => 3800,
                'created_at' => Carbon::now()->subDays(5)->setTime(12, 20),
                'delivered_at' => Carbon::now()->subDays(3)->setTime(13, 45),
                'items' => [
                    ['product' => $westernProducts->first(), 'quantity' => 1, 'unit_price' => 3500],
                    ['product' => $breadProducts->first(), 'quantity' => 1, 'unit_price' => 300],
                ],
                'department_statuses' => [
                    ['department' => $westernDept, 'status' => 'completed', 'user' => $manufacturingUsers->first(), 'started_at' => Carbon::now()->subDays(4)->setTime(7, 0), 'completed_at' => Carbon::now()->subDays(3)->setTime(11, 0)],
                    ['department' => $breadDept, 'status' => 'completed', 'user' => $manufacturingUsers->first(), 'started_at' => Carbon::now()->subDays(4)->setTime(7, 0), 'completed_at' => Carbon::now()->subDays(3)->setTime(10, 30)],
                ]
            ],

            // 10. 古い受け渡し済み注文（2日前）
            [
                'customer' => $customers[9],
                'order_status' => $delivered,
                'total_amount' => 2900,
                'created_at' => Carbon::now()->subDays(4)->setTime(9, 10),
                'delivered_at' => Carbon::now()->subDays(2)->setTime(15, 20),
                'items' => [
                    ['product' => $breadProducts->first(), 'quantity' => 1, 'unit_price' => 2900],
                ],
                'department_statuses' => [
                    ['department' => $breadDept, 'status' => 'completed', 'user' => $manufacturingUsers->first(), 'started_at' => Carbon::now()->subDays(3)->setTime(7, 0), 'completed_at' => Carbon::now()->subDays(2)->setTime(13, 0)],
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
                'pickup_date' => $orderData['delivered_at']->copy()->subDays(1),
                'pickup_time' => $orderData['delivered_at']->copy()->setTime(rand(9, 18), 0),
                'notes' => '古い受け渡し済みサンプル注文データ',
                'requires_packaging' => rand(0, 1),
                'created_at' => $orderData['created_at'],
                'updated_at' => $orderData['delivered_at'],
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
                    'notes' => '古い受け渡し済みサンプルデータ',
                ]);
            }
        }

        echo "10件の古い受け渡し済み注文データを追加しました。" . PHP_EOL;
        echo "注文登録日時は1ヶ月前〜2日前の範囲です。" . PHP_EOL;
    }
}
