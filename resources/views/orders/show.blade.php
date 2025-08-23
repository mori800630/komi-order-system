@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>注文詳細</h2>
    <div>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>注文一覧に戻る
        </a>
        <a href="{{ route('orders.edit', $order) }}" class="btn btn-primary">
            <i class="fas fa-edit me-2"></i>編集
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- 注文情報 -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">注文情報</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">注文番号</label>
                            <p class="mb-0">{{ $order->order_number }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">注文ステータス</label>
                            <p class="mb-0">
                                <span class="status-badge status-{{ $order->orderStatus->code }}">
                                    {{ $order->orderStatus->name }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">注文日</label>
                            <p class="mb-0">{{ $order->created_at->format('Y年m月d日 H:i') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">注文元</label>
                            <p class="mb-0">
                                @switch($order->order_source)
                                    @case('phone')
                                        電話
                                        @break
                                    @case('email')
                                        メール
                                        @break
                                    @case('website')
                                        ウェブサイト
                                        @break
                                    @case('store')
                                        店舗
                                        @break
                                    @case('event')
                                        イベント
                                        @break
                                    @default
                                        その他
                                @endswitch
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">受け渡し方法</label>
                            <p class="mb-0">
                                @if($order->delivery_method == 'pickup')
                                    店舗受け取り
                                @else
                                    配送
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">梱包物流</label>
                            <p class="mb-0">
                                @if($order->requires_packaging)
                                    <span class="badge bg-info">必要</span>
                                @else
                                    <span class="badge bg-light text-dark">不要</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                @if($order->pickup_date)
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">受け取り日</label>
                            <p class="mb-0">{{ $order->pickup_date->format('Y年m月d日') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">受け取り時間</label>
                            <p class="mb-0">{{ $order->pickup_time ?? '指定なし' }}</p>
                        </div>
                    </div>
                </div>
                @endif

                @if($order->notes)
                <div class="mb-3">
                    <label class="form-label fw-bold">備考</label>
                    <p class="mb-0">{{ $order->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- 顧客情報 -->
        @if($order->customer)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">顧客情報</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">顧客番号</label>
                            <p class="mb-0">{{ $order->customer->customer_number }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">顧客名</label>
                            <p class="mb-0">{{ $order->customer->name }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">メールアドレス</label>
                            <p class="mb-0">
                                @if($order->customer->email)
                                    <a href="mailto:{{ $order->customer->email }}">{{ $order->customer->email }}</a>
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
                                @if($order->customer->phone)
                                    <a href="tel:{{ $order->customer->phone }}">{{ $order->customer->phone }}</a>
                                @else
                                    <span class="text-muted">未登録</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                @if($order->customer->postal_code || $order->customer->prefecture || $order->customer->address)
                <div class="mb-3">
                    <label class="form-label fw-bold">住所</label>
                    <p class="mb-0">
                        〒{{ $order->customer->postal_code ?? '' }}<br>
                        {{ $order->customer->prefecture ?? '' }}{{ $order->customer->address ?? '' }}
                    </p>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- 商品一覧 -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">商品一覧</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>商品名</th>
                                <th>製造部門</th>
                                <th>単価</th>
                                <th>数量</th>
                                <th>小計</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>
                                    <span class="department-tag">{{ $item->product->department->name }}</span>
                                </td>
                                <td>¥{{ number_format($item->unit_price) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>¥{{ number_format($item->subtotal) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-end">合計金額:</th>
                                <th>¥{{ number_format($order->total_amount) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- ステータス更新 -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">ステータス更新</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('orders.update-status', $order) }}">
                    @csrf
                    @method('PATCH')
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="order_status_id" class="form-label">新しいステータス</label>
                                <select class="form-select @error('order_status_id') is-invalid @enderror" id="order_status_id" name="order_status_id" required>
                                    @foreach($orderStatuses as $status)
                                        <option value="{{ $status->id }}" {{ $order->order_status_id == $status->id ? 'selected' : '' }}>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('order_status_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-save me-2"></i>ステータス更新
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ステータス履歴 -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">ステータス履歴</h5>
            </div>
            <div class="card-body">
                @if($order->orderStatusHistories->count() > 0)
                    <div class="timeline">
                        @foreach($order->orderStatusHistories->sortByDesc('created_at') as $history)
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">{{ $history->orderStatus->name }}</h6>
                                        @if($history->notes)
                                            <p class="mb-1 small">{{ $history->notes }}</p>
                                        @endif
                                        <small class="text-muted">{{ $history->created_at->format('Y/m/d H:i') }}</small>
                                    </div>
                                    @if($history->user)
                                        <small class="text-muted">{{ $history->user->name }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center py-4">ステータス履歴はありません</p>
                @endif
            </div>
        </div>

        <!-- アクション -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">アクション</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('orders.edit', $order) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>注文を編集
                    </a>
                    @if($order->customer)
                        <a href="{{ route('customers.show', $order->customer) }}" class="btn btn-outline-info">
                            <i class="fas fa-user me-2"></i>顧客詳細
                        </a>
                    @endif
                    <form method="POST" action="{{ route('orders.destroy', $order) }}" 
                          onsubmit="return confirm('この注文を削除しますか？')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash me-2"></i>注文を削除
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background-color: #007bff;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #007bff;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -24px;
    top: 17px;
    width: 2px;
    height: calc(100% + 3px);
    background-color: #e9ecef;
}
</style>
@endsection
