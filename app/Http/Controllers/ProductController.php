<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('department');

        // 権限によるフィルタリング
        if (auth()->user()->isManufacturing()) {
            $query->where('department_id', auth()->user()->department_id);
        }

        // 検索フィルター
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(20);
        $departments = Department::where('is_active', true)->get();

        return view('products.index', compact('products', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::where('is_active', true)->get();
        return view('products.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'name_kana' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:pre_sale,on_sale,discontinued',
            'requires_packaging' => 'boolean',
            'decoration' => 'required|in:available,unavailable',
            'notes' => 'nullable|string|max:1000',
        ]);

        Product::create($request->all());

        return redirect()->route('products.index')
            ->with('success', '商品が正常に登録されました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $departments = Department::where('is_active', true)->get();
        return view('products.edit', compact('product', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'name_kana' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:pre_sale,on_sale,discontinued',
            'requires_packaging' => 'boolean',
            'decoration' => 'required|in:available,unavailable',
            'notes' => 'nullable|string|max:1000',
        ]);

        $product->update($request->all());

        return redirect()->route('products.show', $product)
            ->with('success', '商品情報が正常に更新されました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')
            ->with('success', '商品が正常に削除されました。');
    }
}
