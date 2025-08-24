@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>顧客管理</h2>
    <a href="{{ route('customers.create') }}" class="btn btn-success">
        <i class="fas fa-plus me-2"></i>新規顧客登録
    </a>
</div>

<!-- 検索フィルター -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('customers.index') }}" class="row g-3">
            <div class="col-md-8">
                <label for="search" class="form-label">検索</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="顧客名、顧客番号、メールアドレスで検索">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-search"></i> 検索
                </button>
                <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times"></i> クリア
                </a>
            </div>
        </form>
    </div>
</div>

<!-- 顧客一覧 -->
<div class="card">
    <div class="card-body">
        @if($customers->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>顧客番号</th>
                            <th>顧客名</th>
                            <th>メールアドレス</th>
                            <th>電話番号</th>
                            <th>住所</th>
                            <th>登録日</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                        <tr style="cursor: pointer;" onclick="window.location.href='{{ route('customers.show', $customer) }}'">
                            <td>{{ $customer->customer_number }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email ?? '-' }}</td>
                            <td>{{ $customer->phone ?? '-' }}</td>
                            <td>
                                @if($customer->address)
                                    〒{{ $customer->postal_code }}<br>
                                    {{ $customer->prefecture }}{{ $customer->address }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $customer->created_at->format('Y/m/d') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-outline-secondary" title="編集" onclick="event.stopPropagation();">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('customers.destroy', $customer) }}" class="d-inline" 
                                          onsubmit="return confirm('この顧客を削除しますか？')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="削除" onclick="event.stopPropagation();">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
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
                    {{ $customers->firstItem() }}~{{ $customers->lastItem() }}件 / 全{{ $customers->total() }}件
                </div>
                <div>
                    {{ $customers->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">顧客が見つかりません</h5>
                <p class="text-muted">検索条件を変更するか、新しい顧客を登録してください。</p>
            </div>
        @endif
    </div>
</div>
@endsection
