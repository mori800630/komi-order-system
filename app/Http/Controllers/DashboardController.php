<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // 今日の注文数
        $todayOrders = Order::whereDate('created_at', $today)->count();

        // 各ステータスの注文数を取得
        $orderReceivedStatus = OrderStatus::where('code', 'order_received')->first();
        $manufacturingStatus = OrderStatus::where('code', 'manufacturing')->first();
        $packagingStatus = OrderStatus::where('code', 'packaging')->first();
        $inTransitStatus = OrderStatus::where('code', 'in_transit')->first();
        $deliveredStatus = OrderStatus::where('code', 'delivered')->first();

        $orderReceivedOrders = $orderReceivedStatus ? Order::where('order_status_id', $orderReceivedStatus->id)->count() : 0;
        $manufacturingOrders = $manufacturingStatus ? Order::where('order_status_id', $manufacturingStatus->id)->count() : 0;
        $packagingOrders = $packagingStatus ? Order::where('order_status_id', $packagingStatus->id)->count() : 0;
        $inTransitOrders = $inTransitStatus ? Order::where('order_status_id', $inTransitStatus->id)->count() : 0;
        $deliveredOrders = $deliveredStatus ? Order::where('order_status_id', $deliveredStatus->id)->count() : 0;

        // 今日の売上
        $todaySales = Order::whereDate('created_at', $today)->sum('total_amount');

        // 最近の注文（最新10件）
        $recentOrders = Order::with(['customer', 'orderStatus'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // 部門別統計
        $departmentStats = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('departments', 'products.department_id', '=', 'departments.id')
            ->join('order_statuses', 'orders.order_status_id', '=', 'order_statuses.id')
            ->select(
                'departments.name as department_name',
                DB::raw('COUNT(DISTINCT orders.id) as order_count'),
                DB::raw('COUNT(CASE WHEN order_statuses.code = "manufacturing" THEN orders.id END) as manufacturing_count')
            )
            ->groupBy('departments.id', 'departments.name')
            ->get();

        return view('dashboard', compact(
            'todayOrders',
            'orderReceivedOrders',
            'manufacturingOrders',
            'packagingOrders',
            'inTransitOrders',
            'deliveredOrders',
            'todaySales',
            'recentOrders',
            'departmentStats'
        ));
    }
}
