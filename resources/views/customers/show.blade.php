@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>顧客詳細</h2>
    <div>
        <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>顧客一覧に戻る
        </a>
        <a href="{{ route('customers.edit', $customer) }}" class="btn btn-primary">
            <i class="fas fa-edit me-2"></i>編集
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- 顧客情報 -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">顧客情報</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">顧客番号</label>
                            <p class="mb-0">{{ $customer->customer_number }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">顧客名</label>
                            <p class="mb-0">{{ $customer->name }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">メールアドレス</label>
                            <p class="mb-0">
                                @if($customer->email)
                                    <a href="mailto:{{ $customer->email }}">{{ $customer->email }}</a>
                                @else
                                    <span class="text-muted">未登録</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">電話番号</label>
                            <p class="mb-0">
                                @if($customer->phone)
                                    <a href="tel:{{ $customer->phone }}">{{ $customer->phone }}</a>
                                @else
                                    <span class="text-muted">未登録</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">住所</label>
                    <p class="mb-0">
                        @if($customer->postal_code || $customer->prefecture || $customer->address)
                            〒{{ $customer->postal_code ?? '' }}<br>
                            {{ $customer->prefecture ?? '' }}{{ $customer->address ?? '' }}
                        @else
                            <span class="text-muted">未登録</span>
                        @endif
                    </p>
                </div>

                @if($customer->notes)
                <div class="mb-3">
                    <label class="form-label fw-bold">備考</label>
                    <p class="mb-0">{{ $customer->notes }}</p>
                </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">登録日</label>
                            <p class="mb-0">{{ $customer->created_at->format('Y年m月d日') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">更新日</label>
                            <p class="mb-0">{{ $customer->updated_at->format('Y年m月d日') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 注文履歴 -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">注文履歴</h5>
            </div>
            <div class="card-body">
                @if($customer->orders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>注文番号</th>
                                    <th>注文日</th>
                                    <th>商品数</th>
                                    <th>合計金額</th>
                                    <th>ステータス</th>
                                    <th>アクション</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customer->orders->sortByDesc('created_at')->take(10) as $order)
                                <tr>
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->created_at->format('Y/m/d') }}</td>
                                    <td>{{ $order->orderItems->count() }}点</td>
                                    <td>¥{{ number_format($order->total_amount) }}</td>
                                    <td>
                                        <span class="status-badge status-{{ $order->orderStatus->code }}">
                                            {{ $order->orderStatus->name }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($customer->orders->count() > 10)
                        <p class="text-muted text-center mt-3">
                            他 {{ $customer->orders->count() - 10 }}件の注文があります
                        </p>
                    @endif
                @else
                    <p class="text-muted text-center py-4">この顧客の注文履歴はありません</p>
                @endif
            </div>
        </div>
    </div>

    <!-- 顧客サマリー -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">顧客サマリー</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>総注文件数:</span>
                    <span>{{ $customer->orders->count() }}件</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>総購入金額:</span>
                    <span>¥{{ number_format($customer->orders->sum('total_amount')) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>平均注文金額:</span>
                    <span>
                        @if($customer->orders->count() > 0)
                            ¥{{ number_format($customer->orders->avg('total_amount')) }}
                        @else
                            ¥0
                        @endif
                    </span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>最終注文日:</span>
                    <span>
                        @if($customer->orders->count() > 0)
                            {{ $customer->orders->sortByDesc('created_at')->first()->created_at->format('Y/m/d') }}
                        @else
                            なし
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- アクション -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">アクション</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('customers.edit', $customer) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>顧客を編集
                    </a>
                    <a href="{{ route('orders.create', ['customer_id' => $customer->id]) }}" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>新規注文
                    </a>
                    <form method="POST" action="{{ route('customers.destroy', $customer) }}" 
                          onsubmit="return confirm('この顧客を削除しますか？関連する注文も削除されます。')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash me-2"></i>顧客を削除
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
