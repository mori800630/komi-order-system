@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>商品詳細</h2>
    <div>
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>商品一覧に戻る
        </a>
        <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">
            <i class="fas fa-edit me-2"></i>編集
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- 商品情報 -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">商品情報</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">商品名</label>
                    <p class="mb-0">{{ $product->name }}</p>
                </div>
                
                @if($product->name_kana)
                <div class="mb-3">
                    <label class="form-label fw-bold">商品名 (ふりがな)</label>
                    <p class="mb-0">{{ $product->name_kana }}</p>
                </div>
                @endif
                
                <div class="mb-3">
                    <label class="form-label fw-bold">製造部門</label>
                    <p class="mb-0">
                        <span class="department-tag">{{ $product->department->name }}</span>
                    </p>
                </div>
                
                @if($product->description)
                <div class="mb-3">
                    <label class="form-label fw-bold">商品説明</label>
                    <p class="mb-0">{{ $product->description }}</p>
                </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">価格</label>
                            <p class="mb-0">¥{{ number_format($product->price) }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">販売ステータス</label>
                            <p class="mb-0">
                                @switch($product->status)
                                    @case('pre_sale')
                                        <span class="badge bg-warning">販売前</span>
                                        @break
                                    @case('on_sale')
                                        <span class="badge bg-success">販売中</span>
                                        @break
                                    @case('discontinued')
                                        <span class="badge bg-secondary">販売終了</span>
                                        @break
                                @endswitch
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">梱包物流</label>
                            <p class="mb-0">
                                @if($product->requires_packaging)
                                    <span class="badge bg-info">対象</span>
                                @else
                                    <span class="badge bg-light text-dark">対象外</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">デコレーション</label>
                            <p class="mb-0">
                                @if($product->decoration == 'available')
                                    <span class="badge bg-success">可</span>
                                @else
                                    <span class="badge bg-secondary">不可</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">登録日</label>
                            <p class="mb-0">{{ $product->created_at->format('Y年m月d日') }}</p>
                        </div>
                    </div>
                </div>

                @if($product->notes)
                <div class="mb-3">
                    <label class="form-label fw-bold">備考</label>
                    <p class="mb-0">{{ $product->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- 注文履歴 -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">注文履歴</h5>
            </div>
            <div class="card-body">
                @if($product->orderItems->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>注文番号</th>
                                    <th>顧客名</th>
                                    <th>数量</th>
                                    <th>注文日</th>
                                    <th>ステータス</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($product->orderItems->take(10) as $item)
                                <tr>
                                    <td>
                                        <a href="{{ route('orders.show', $item->order) }}" class="text-decoration-none">
                                            {{ $item->order->order_number }}
                                        </a>
                                    </td>
                                    <td>{{ $item->order->customer->name ?? '未登録' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->order->created_at->format('Y/m/d') }}</td>
                                    <td>
                                        <span class="status-badge status-{{ $item->order->orderStatus->code }}">
                                            {{ $item->order->orderStatus->name }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($product->orderItems->count() > 10)
                        <p class="text-muted text-center mt-3">
                            他 {{ $product->orderItems->count() - 10 }}件の注文があります
                        </p>
                    @endif
                @else
                    <p class="text-muted text-center py-4">この商品の注文履歴はありません</p>
                @endif
            </div>
        </div>
    </div>

    <!-- 商品サマリー -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">商品サマリー</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>総注文数:</span>
                    <span>{{ $product->orderItems->sum('quantity') }}個</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>注文件数:</span>
                    <span>{{ $product->orderItems->count() }}件</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>総売上:</span>
                    <span>¥{{ number_format($product->orderItems->sum('subtotal')) }}</span>
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
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>商品を編集
                    </a>
                    <form method="POST" action="{{ route('products.destroy', $product) }}" 
                          onsubmit="return confirm('この商品を削除しますか？')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash me-2"></i>商品を削除
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
