<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Department;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'orderStatus', 'orderItems.product.department']);

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
        $products = Product::active()->with('department')->get();
        $departments = Department::where('is_active', true)->get();
        $orderStatuses = OrderStatus::active()->ordered()->get();

        return view('orders.create', compact('customers', 'products', 'departments', 'orderStatuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
            'products' => 'required|array|min:1',
            'prices' => 'required|array|min:1',
            'quantities' => 'required|array|min:1',
        ]);

        DB::beginTransaction();
        try {
            $order = Order::create([
                'customer_id' => $request->customer_id,
                'order_status_id' => $request->order_status_id,
                'order_source' => $request->order_source,
                'delivery_method' => $request->delivery_method,
                'pickup_date' => $request->pickup_date,
                'pickup_time' => $request->pickup_time,
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
            return back()->with('error', '注文の登録に失敗しました。');
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
        $products = Product::active()->with('department')->get();
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
        ]);

        $order->update($request->only([
            'customer_id', 'order_status_id', 'order_source', 'delivery_method',
            'pickup_date', 'pickup_time', 'notes'
        ]));

        return redirect()->route('orders.show', $order)
            ->with('success', '注文が正常に更新されました。');
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
        $request->validate([
            'order_status_id' => 'required|exists:order_statuses,id',
            'notes' => 'nullable|string',
        ]);

        $oldStatus = $order->orderStatus;
        $newStatus = OrderStatus::find($request->order_status_id);

        // ステータスの順序チェック（一方通行）
        if ($newStatus->sort_order <= $oldStatus->sort_order) {
            return back()->with('error', 'ステータスは前進のみ可能です。');
        }

        $order->update(['order_status_id' => $request->order_status_id]);

        // ステータス変更履歴を記録
        $order->orderStatusHistories()->create([
            'order_status_id' => $request->order_status_id,
            'user_id' => auth()->id(),
            'notes' => $request->notes,
        ]);

        return redirect()->route('orders.show', $order)
            ->with('success', 'ステータスが正常に更新されました。');
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
