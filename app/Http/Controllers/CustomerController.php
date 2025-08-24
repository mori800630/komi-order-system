<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('customer_number', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $customers = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|string|max:20',
            'postal_code' => 'required|string|max:10',
            'prefecture' => 'required|string|max:50',
            'address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        Customer::create($request->all());

        return redirect()->route('customers.index')
            ->with('success', '顧客が正常に登録されました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json($customer);
        }
        
        $customer->load('orders.orderStatus');
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone' => 'required|string|max:20',
            'postal_code' => 'required|string|max:10',
            'prefecture' => 'required|string|max:50',
            'address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        $customer->update($request->all());

        return redirect()->route('customers.show', $customer)
            ->with('success', '顧客情報が正常に更新されました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')
            ->with('success', '顧客が正常に削除されました。');
    }

    /**
     * Get customer data for API
     */
    public function getCustomerData(Customer $customer)
    {
        return response()->json($customer);
    }
}
