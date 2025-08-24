<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Department;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\OrderStatusTransition;
use App\Models\Product;
use App\Rules\AllDepartmentsCompleted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'orderStatus', 'orderItems.product.department', 'departmentStatuses']);

        // 権限によるフィルタリング
        if (auth()->user()->isManufacturing()) {
            $query->whereHas('orderItems.product', function ($q) {
                $q->where('department_id', auth()->user()->department_id);
            });
        }

        // 検索フィルター
        if ($request->filled('customer_name')) {
            $query->whereHas('customer', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->customer_name . '%');
            });
        }

        if ($request->filled('order_status')) {
            $query->where('order_status_id', $request->order_status);
        }

        if ($request->filled('department')) {
            $query->whereHas('orderItems.product', function ($q) use ($request) {
                $q->where('department_id', $request->department);
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);
        $orderStatuses = OrderStatus::active()->ordered()->get();
        $departments = Department::where('is_active', true)->get();

        return view('orders.index', compact('orders', 'orderStatuses', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::where('is_active', true)->get();
        // 販売中の商品のみを取得
        $products = Product::where('status', 'on_sale')->where('is_active', true)->with('department')->get();
        $departments = Department::where('is_active', true)->get();
        $orderStatuses = OrderStatus::active()->ordered()->get();

        return view('orders.create', compact('customers', 'products', 'departments', 'orderStatuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // デバッグ情報をログに出力
        \Log::info('Order store request data:', $request->all());
        
        $validator = \Validator::make($request->all(), [
            'customer_id' => 'nullable|exists:customers,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'customer_email' => 'nullable|email',
            'customer_postal_code' => 'nullable|string|max:10',
            'customer_prefecture' => 'nullable|string|max:50',
            'customer_address' => 'nullable|string|max:500',
            'order_status_id' => 'required|exists:order_statuses,id',
            'order_source' => 'required|in:phone,store,pickup_site,delivery_site,email,event,other',
            'delivery_method' => 'required|in:pickup,delivery',
            'pickup_date' => 'nullable|date|required_if:delivery_method,pickup',
            'pickup_time' => 'nullable|required_if:delivery_method,pickup',
            'delivery_name' => 'nullable|string|required_if:delivery_method,delivery',
            'delivery_phone' => 'nullable|string|required_if:delivery_method,delivery',
            'delivery_postal_code' => 'nullable|string|required_if:delivery_method,delivery',
            'delivery_prefecture' => 'nullable|string|required_if:delivery_method,delivery',
            'delivery_address' => 'nullable|string|required_if:delivery_method,delivery',
            'notes' => 'nullable|string',
            'requires_packaging' => 'required|boolean',
            'products' => 'required|array|min:1',
            'prices' => 'required|array|min:1',
            'quantities' => 'required|array|min:1',
        ]);

        if ($validator->fails()) {
            \Log::error('Validation errors:', $validator->errors()->toArray());
            return back()->withErrors($validator)->withInput();
        }



        DB::beginTransaction();
        try {
            $order = Order::create([
                'customer_id' => $request->customer_id,
                'order_status_id' => $request->order_status_id,
                'order_source' => $request->order_source,
                'delivery_method' => $request->delivery_method,
                'pickup_date' => $request->pickup_date,
                'pickup_time' => $request->pickup_time,
                'requires_packaging' => $request->requires_packaging,
                'notes' => $request->notes,
                'total_amount' => 0,
            ]);

            $totalAmount = 0;
            foreach ($request->products as $index => $productId) {
                $product = Product::find($productId);
                $quantity = $request->quantities[$index];
                $price = $request->prices[$index];
                $subtotal = $price * $quantity;
                $totalAmount += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'unit_price' => $price,
                    'subtotal' => $subtotal,
                ]);
            }

            $order->update(['total_amount' => $totalAmount]);

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', '注文が正常に登録されました。');
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Order creation failed:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', '注文の登録に失敗しました。: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['customer', 'orderStatus', 'orderItems.product.department']);
        $orderStatuses = OrderStatus::active()->ordered()->get();

        return view('orders.show', compact('order', 'orderStatuses'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $order->load(['customer', 'orderStatus', 'orderItems.product.department']);
        $customers = Customer::where('is_active', true)->get();
        // 販売中の商品のみを取得（既存の注文商品は含める）
        $existingProductIds = $order->orderItems->pluck('product_id')->toArray();
        $products = Product::where(function($query) use ($existingProductIds) {
            $query->where('status', 'on_sale')
                  ->orWhereIn('id', $existingProductIds);
        })->where('is_active', true)->with('department')->get();
        $departments = Department::where('is_active', true)->get();
        $orderStatuses = OrderStatus::active()->ordered()->get();

        return view('orders.edit', compact('order', 'customers', 'products', 'departments', 'orderStatuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'customer_email' => 'nullable|email',
            'customer_postal_code' => 'nullable|string|max:10',
            'customer_prefecture' => 'nullable|string|max:50',
            'customer_address' => 'nullable|string|max:500',
            'order_status_id' => 'required|exists:order_statuses,id',
            'order_source' => 'required|in:phone,store,pickup_site,delivery_site,email,event,other',
            'delivery_method' => 'required|in:pickup,delivery',
            'pickup_date' => 'nullable|date|required_if:delivery_method,pickup',
            'pickup_time' => 'nullable|required_if:delivery_method,pickup',
            'delivery_name' => 'nullable|string|required_if:delivery_method,delivery',
            'delivery_phone' => 'nullable|string|required_if:delivery_method,delivery',
            'delivery_postal_code' => 'nullable|string|required_if:delivery_method,delivery',
            'delivery_prefecture' => 'nullable|string|required_if:delivery_method,delivery',
            'delivery_address' => 'nullable|string|required_if:delivery_method,delivery',
            'notes' => 'nullable|string',
            'requires_packaging' => 'required|boolean',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.unit_price' => 'required|integer|min:0',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            // 注文の基本情報を更新
            $order->update($request->only([
                'customer_id', 'order_status_id', 'order_source', 'delivery_method',
                'pickup_date', 'pickup_time', 'requires_packaging', 'notes'
            ]));

            // 既存の注文アイテムを削除
            $order->orderItems()->delete();

            // 新しい注文アイテムを作成
            $totalAmount = 0;
            foreach ($request->items as $item) {
                $subtotal = $item['unit_price'] * $item['quantity'];
                $totalAmount += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $subtotal,
                ]);
            }

            // 合計金額を更新
            $order->update(['total_amount' => $totalAmount]);

            DB::commit();

            return redirect()->route('orders.show', $order)
                ->with('success', '注文が正常に更新されました。');
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Order update failed:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', '注文の更新に失敗しました。: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')
            ->with('success', '注文が正常に削除されました。');
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        try {
            $request->validate([
                'new_status_id' => [
                    'required',
                    'exists:order_statuses,id',
                    new AllDepartmentsCompleted($order, $order->order_status_id)
                ],
                'notes' => 'nullable|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->validator)->withInput();
        }

        $newStatus = OrderStatus::find($request->new_status_id);
        $user = auth()->user();

        // 遷移の権限チェック
        $transition = OrderStatusTransition::where('from_status_id', $order->order_status_id)
            ->where('to_status_id', $request->new_status_id)
            ->where('is_active', true)
            ->first();

        if (!$transition || !$transition->canTransition($user, $order)) {
            return back()->with('error', 'このステータス変更は許可されていません。');
        }

        $oldStatus = $order->orderStatus;
        $order->update(['order_status_id' => $request->new_status_id]);

        // ステータス変更履歴を記録
        $order->orderStatusHistories()->create([
            'order_status_id' => $request->new_status_id,
            'user_id' => auth()->id(),
            'notes' => $request->notes,
        ]);

        return redirect()->route('orders.show', $order)
            ->with('success', 'ステータスが正常に更新されました。');
    }

    /**
     * Update department status
     */
    public function updateDepartmentStatus(Request $request, Order $order)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'status' => 'required|in:not_started,in_progress,completed',
            'notes' => 'nullable|string',
        ]);

        $department = Department::find($request->department_id);
        $user = auth()->user();

        // 権限チェック
        if (!$user->isAdmin() && !($user->isManufacturing() && $user->department_id == $department->id)) {
            return back()->with('error', 'この操作を実行する権限がありません。');
        }

        // 部門別ステータスを更新または作成
        $deptStatus = $order->departmentStatuses()->updateOrCreate(
            ['department_id' => $request->department_id],
            [
                'status' => $request->status,
                'user_id' => $user->id,
                'notes' => $request->notes,
            ]
        );

        // 開始・完了日時を更新
        if ($request->status === 'in_progress' && !$deptStatus->started_at) {
            $deptStatus->update(['started_at' => now()]);
        } elseif ($request->status === 'completed' && !$deptStatus->completed_at) {
            $deptStatus->update(['completed_at' => now()]);
        }

        return redirect()->route('orders.show', $order)
            ->with('success', '部門ステータスが正常に更新されました。');
    }

    /**
     * Update packaging requirement
     */
    public function updatePackaging(Request $request, Order $order)
    {
        $request->validate([
            'requires_packaging' => 'required|boolean',
        ]);

        $order->update([
            'requires_packaging' => $request->requires_packaging,
        ]);

        return redirect()->route('orders.show', $order)
            ->with('success', '梱包物流設定が正常に更新されました。');
    }

    /**
     * Department orders view
     */
    public function departmentOrders(Department $department)
    {
        $orders = Order::with(['customer', 'orderStatus', 'orderItems.product.department'])
            ->whereHas('orderItems.product', function ($query) use ($department) {
                $query->where('department_id', $department->id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('orders.department', compact('orders', 'department'));
    }
}
