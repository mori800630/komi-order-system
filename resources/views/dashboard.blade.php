@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex align-items-center">
        <h2 class="mb-0">ダッシュボード</h2>
    </div>
    <div>
        <a href="{{ route('orders.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>新規注文登録
        </a>
    </div>
</div>

<div class="row">
    <!-- 統計カード -->
    <div class="col-md-2 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">今日の注文</h6>
                        <h3 class="mb-0">{{ $todayOrders }}</h3>
                    </div>
                    <div class="text-primary">
                        <i class="fas fa-shopping-cart fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-2 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">注文受付</h6>
                        <h3 class="mb-0">{{ $orderReceivedOrders }}</h3>
                    </div>
                    <div class="text-secondary">
                        <i class="fas fa-clipboard-list fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-2 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">製造中</h6>
                        <h3 class="mb-0">{{ $manufacturingOrders }}</h3>
                    </div>
                    <div class="text-warning">
                        <i class="fas fa-industry fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-2 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">梱包中</h6>
                        <h3 class="mb-0">{{ $packagingOrders }}</h3>
                    </div>
                    <div class="text-info">
                        <i class="fas fa-box fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-2 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">輸送中</h6>
                        <h3 class="mb-0">{{ $inTransitOrders }}</h3>
                    </div>
                    <div class="text-primary">
                        <i class="fas fa-truck fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-2 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">受け渡し済み</h6>
                        <h3 class="mb-0">{{ $deliveredOrders }}</h3>
                    </div>
                    <div class="text-success">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">今日の売上</h6>
                        <h3 class="mb-0">¥{{ number_format($todaySales) }}</h3>
                    </div>
                    <div class="text-success">
                        <i class="fas fa-yen-sign fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- 最近の注文 -->
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">最近の注文</h5>
            </div>
            <div class="card-body">
                @if($recentOrders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>注文番号</th>
                                    <th>顧客名</th>
                                    <th>ステータス</th>
                                    <th>金額</th>
                                    <th>登録日時</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr style="cursor: pointer;" onclick="window.location.href='{{ route('orders.show', $order) }}'">
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->customer->name ?? '未登録' }}</td>
                                    <td>
                                        <span class="status-badge status-{{ $order->orderStatus->code }}">
                                            {{ $order->orderStatus->name }}
                                        </span>
                                    </td>
                                    <td>¥{{ number_format($order->total_amount) }}</td>
                                    <td>{{ $order->created_at->format('m/d H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center py-4">最近の注文はありません</p>
                @endif
            </div>
        </div>
    </div>

    <!-- 部門別注文状況 -->
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">部門別注文状況</h5>
            </div>
            <div class="card-body">
                @foreach($departmentStats as $stat)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h6 class="mb-0">{{ $stat->department_name }}</h6>
                        <small class="text-muted">{{ $stat->order_count }}件</small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-primary">{{ $stat->manufacturing_count }}製造中</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
