<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Product; // Added this import for the new API route

// 認証ルート
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 認証が必要なルート
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // ダッシュボード
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // 注文管理
    Route::resource('orders', OrderController::class);
    Route::post('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::post('/orders/{order}/update-department-status', [OrderController::class, 'updateDepartmentStatus'])->name('orders.update-department-status');
    Route::post('/orders/{order}/update-packaging', [OrderController::class, 'updatePackaging'])->name('orders.update-packaging');
    
    // 顧客管理
    Route::resource('customers', CustomerController::class);
    
    // 顧客情報取得API（CSRF除外）
    Route::get('/api/customers/{customer}', [CustomerController::class, 'getCustomerData'])->name('api.customers.show');
    
    // 商品管理
    Route::resource('products', ProductController::class);
    
    // 商品ページネーション用API
    Route::get('/api/products', function (Request $request) {
        $products = Product::where('status', 'on_sale')
            ->where('is_active', true)
            ->with('department')
            ->paginate(20);
        
        return response()->json($products);
    })->name('api.products');
    
    // ユーザー管理（管理者のみ）
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::resource('users', UserController::class);
    });
    
    // 部門別注文表示（製造部門用）
    Route::get('/department/{department}/orders', [OrderController::class, 'departmentOrders'])->name('department.orders');
});

Route::get('/debug/form', function () {
    return view('debug.form');
})->name('debug.form');

Route::post('/debug/test', function (Request $request) {
    \Log::info('Debug form submitted:', $request->all());
    return response()->json(['success' => true, 'data' => $request->all()]);
})->name('debug.test');
