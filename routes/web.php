<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
    
    // 顧客管理
    Route::resource('customers', CustomerController::class);
    
    // 顧客情報取得API（CSRF除外）
    Route::get('/api/customers/{customer}', [CustomerController::class, 'getCustomerData'])->name('api.customers.show');
    
    // 商品管理
    Route::resource('products', ProductController::class);
    
    // ユーザー管理（管理者のみ）
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::resource('users', UserController::class);
    });
    
    // 部門別注文表示（製造部門用）
    Route::get('/department/{department}/orders', [OrderController::class, 'departmentOrders'])->name('department.orders');
});
