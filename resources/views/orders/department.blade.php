@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>{{ $department->name }} - 注文一覧</h2>
        <p class="text-muted mb-0">{{ $department->description }}</p>
    </div>
    <div>
        <a href="{{ route('orders.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>新規注文登録
        </a>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary ms-2">
            <i class="fas fa-arrow-left me-2"></i>全注文一覧に戻る
        </a>
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
                            <th>金額</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->created_at->format('Y/m/d H:i') }}</td>
                            <td>{{ $order->customer->name ?? '未登録' }}</td>
                            <td>
                                @switch($order->order_source)
                                    @case('phone')
                                        <span class="badge bg-primary">電話注文</span>
                                        @break
                                    @case('email')
                                        <span class="badge bg-info">メール注文</span>
                                        @break
                                    @case('website')
                                        <span class="badge bg-success">ウェブサイト</span>
                                        @break
                                    @case('store')
                                        <span class="badge bg-warning">店舗</span>
                                        @break
                                    @case('event')
                                        <span class="badge bg-secondary">イベント</span>
                                        @break
                                    @default
                                        <span class="badge bg-dark">その他</span>
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
                                    @if($order->orderStatus->sort_order < 5)
                                        <i class="fas fa-arrow-right ms-2 text-muted"></i>
                                    @endif
                                </div>
                            </td>
                            <td>¥{{ number_format($order->total_amount) }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary" title="詳細表示">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('orders.edit', $order) }}" class="btn btn-sm btn-outline-secondary" title="編集">
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
                <div>
                    {{ $orders->firstItem() }}~{{ $orders->lastItem() }}件 / 全{{ $orders->total() }}件
                </div>
                <div>
                    {{ $orders->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">{{ $department->name }}の注文が見つかりません</h5>
                <p class="text-muted">この部門に関連する注文はまだありません。</p>
                <a href="{{ route('orders.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>新規注文を登録
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
