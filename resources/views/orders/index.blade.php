@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>注文管理</h2>
    <div>
        <a href="{{ route('orders.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>新規注文登録
        </a>
    </div>
</div>

<!-- フィルター -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('orders.index') }}" class="row g-3">
            <div class="col-md-2">
                <label for="customer_name" class="form-label">お客様名</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name" 
                       value="{{ request('customer_name') }}" placeholder="顧客名を入力">
            </div>
            <div class="col-md-2">
                <label for="department" class="form-label">製造部門</label>
                <select class="form-select" id="department" name="department">
                    <option value="">すべて</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="order_status" class="form-label">注文ステータス</label>
                <select class="form-select" id="order_status" name="order_status">
                    <option value="">すべて</option>
                    @foreach($orderStatuses as $status)
                        <option value="{{ $status->id }}" {{ request('order_status') == $status->id ? 'selected' : '' }}>
                            {{ $status->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="order_source" class="form-label">注文ソース</label>
                <select class="form-select" id="order_source" name="order_source">
                    <option value="">すべて</option>
                    <option value="phone" {{ request('order_source') == 'phone' ? 'selected' : '' }}>電話注文</option>
                    <option value="store" {{ request('order_source') == 'store' ? 'selected' : '' }}>来店注文</option>
                    <option value="pickup_site" {{ request('order_source') == 'pickup_site' ? 'selected' : '' }}>店頭受け取り予約サイト</option>
                    <option value="delivery_site" {{ request('order_source') == 'delivery_site' ? 'selected' : '' }}>お取り寄せ専用サイト</option>
                    <option value="email" {{ request('order_source') == 'email' ? 'selected' : '' }}>メール注文</option>
                    <option value="event" {{ request('order_source') == 'event' ? 'selected' : '' }}>催事・イベント</option>
                    <option value="other" {{ request('order_source') == 'other' ? 'selected' : '' }}>その他</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="delivery_method" class="form-label">梱包物流</label>
                <select class="form-select" id="delivery_method" name="delivery_method">
                    <option value="">すべて</option>
                    <option value="pickup" {{ request('delivery_method') == 'pickup' ? 'selected' : '' }}>店頭受け取り</option>
                    <option value="delivery" {{ request('delivery_method') == 'delivery' ? 'selected' : '' }}>お取り寄せ</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-search"></i> 検索
                </button>
                <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times"></i> クリア
                </a>
            </div>
        </form>
    </div>
</div>

<!-- 注文一覧 -->
<div class="card">
    <div class="card-body">
        @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>注文番号</th>
                            <th>注文登録日時</th>
                            <th>お客様名</th>
                            <th>注文ソース</th>
                            <th>受け取り日時</th>
                            <th>注文ステータス</th>
                            <th>梱包物流</th>
                            <th>金額</th>
                            <th>製造部門</th>
                            <th>編集</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr @if($order->orderStatus->code === 'order_received') class="table-danger" style="background: linear-gradient(45deg, #ffebee, #ffcdd2);" @endif 
                            onclick="window.location.href='{{ route('orders.show', $order) }}'" 
                            style="cursor: pointer;" 
                            class="order-row">
                            <td>
                                @if($order->orderStatus->code === 'order_received')
                                    <i class="fas fa-exclamation-triangle text-danger me-1" title="製造開始待ち"></i>
                                @endif
                                {{ $order->order_number }}
                            </td>
                            <td>{{ $order->created_at->format('Y/m/d H:i') }}</td>
                            <td>{{ $order->customer->name ?? '未登録' }}</td>
                            <td>
                                @switch($order->order_source)
                                    @case('phone')
                                        <span class="badge bg-primary">電話注文</span>
                                        @break
                                    @case('store')
                                        <span class="badge bg-warning">来店注文</span>
                                        @break
                                    @case('pickup_site')
                                        <span class="badge bg-info">店頭受け取り予約サイト</span>
                                        @break
                                    @case('delivery_site')
                                        <span class="badge bg-success">お取り寄せ専用サイト</span>
                                        @break
                                    @case('email')
                                        <span class="badge bg-info">メール注文</span>
                                        @break
                                    @case('event')
                                        <span class="badge bg-secondary">催事・イベント</span>
                                        @break
                                    @case('other')
                                        <span class="badge bg-dark">その他</span>
                                        @break
                                    @default
                                        <span class="badge bg-light text-dark">未選択</span>
                                @endswitch
                            </td>
                            <td>
                                @if($order->pickup_date)
                                    {{ $order->pickup_date->format('Y/m/d') }}
                                    @if($order->pickup_time)
                                        ({{ $order->pickup_time }})
                                    @endif
                                    <br>
                                    <span class="badge bg-success">受け取り</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="status-badge status-{{ $order->orderStatus->code }}">
                                        {{ $order->orderStatus->name }}
                                    </span>
                                </div>
                                
                                <!-- ステータス遷移ボタン -->
                                @php
                                    $availableTransitions = $order->getAllAvailableTransitions();
                                @endphp
                                @if($availableTransitions->count() > 0)
                                    <div class="mt-1">
                                        @foreach($availableTransitions as $transition)
                                            <form action="{{ route('orders.update-status', $order) }}" method="POST" class="d-inline me-1">
                                                @csrf
                                                <input type="hidden" name="new_status_id" value="{{ $transition->to_status_id }}">
                                                <button type="submit" class="btn btn-xs btn-outline-primary" 
                                                        onclick="event.stopPropagation(); return confirm('ステータスを「{{ $transition->toStatus->name }}」に変更しますか？')"
                                                        title="{{ $transition->toStatus->name }}へ変更">
                                                    <i class="fas fa-arrow-right"></i>
                                                </button>
                                            </form>
                                        @endforeach
                                    </div>
                                @endif
                            </td>
                            <td>
                                @if($order->requires_packaging)
                                    <span class="badge bg-info">必要</span>
                                @else
                                    <span class="badge bg-light text-dark">不要</span>
                                @endif
                            </td>
                            <td>¥{{ number_format($order->total_amount) }}</td>
                            <td>
                                @foreach($order->orderItems->pluck('product.department')->unique() as $department)
                                    @php
                                        $deptStatus = $order->departmentStatuses()->where('department_id', $department->id)->first();
                                        $currentStatus = $deptStatus ? $deptStatus->status : 'not_started';
                                    @endphp
                                    
                                    <div class="mb-1">
                                        <span class="department-tag">{{ $department->name }}</span>
                                        <span class="badge {{ $deptStatus ? $deptStatus->status_badge_class : 'bg-secondary' }} ms-1">
                                            {{ $deptStatus ? $deptStatus->status_text : '未開始' }}
                                        </span>
                                    </div>
                                @endforeach
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('orders.edit', $order) }}" class="btn btn-sm btn-outline-secondary" title="編集" onclick="event.stopPropagation();">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- ページネーション -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    {{ $orders->firstItem() }}~{{ $orders->lastItem() }}件 / 全{{ $orders->total() }}件
                </div>
                <div>
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">注文が見つかりません</h5>
                <p class="text-muted">検索条件を変更するか、新しい注文を登録してください。</p>
            </div>
        @endif
    </div>
</div>
<style>
.order-row:hover {
    background-color: rgba(0, 123, 255, 0.1) !important;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.2s ease;
}

.order-row {
    transition: all 0.2s ease;
}
</style>
@endsection
