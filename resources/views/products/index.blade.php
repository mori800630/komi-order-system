@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>商品管理</h2>
    <div>
        <a href="{{ route('products.create') }}" class="btn btn-success">
            <i class="fas fa-plus me-2"></i>新規商品登録
        </a>
    </div>
</div>

<!-- 検索フィルター -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('products.index') }}" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">商品名検索</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="商品名で検索">
            </div>
            <div class="col-md-3">
                <label for="department" class="form-label">部門</label>
                <select class="form-select" id="department" name="department">
                    <option value="">すべて</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ request('department') == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label">販売ステータス</label>
                <select class="form-select" id="status" name="status">
                    <option value="">すべて</option>
                    <option value="pre_sale" {{ request('status') == 'pre_sale' ? 'selected' : '' }}>販売前</option>
                    <option value="on_sale" {{ request('status') == 'on_sale' ? 'selected' : '' }}>販売中</option>
                    <option value="discontinued" {{ request('status') == 'discontinued' ? 'selected' : '' }}>販売終了</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-search"></i> 検索
                </button>
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times"></i> クリア
                </a>
            </div>
        </form>
    </div>
</div>

<!-- 商品一覧 -->
<div class="card">
    <div class="card-body">
        @if($products->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>商品名</th>
                            <th>部門</th>
                            <th>価格</th>
                            <th>販売ステータス</th>
                            <th>梱包物流</th>
                            <th>登録日</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>
                                <strong>{{ $product->name }}</strong>
                                @if($product->description)
                                    <br><small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="department-tag">{{ $product->department->name }}</span>
                            </td>
                            <td>¥{{ number_format($product->price) }}</td>
                            <td>
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
                            </td>
                            <td>
                                @if($product->requires_packaging)
                                    <span class="badge bg-info">必要</span>
                                @else
                                    <span class="badge bg-light text-dark">不要</span>
                                @endif
                            </td>
                            <td>{{ $product->created_at->format('Y/m/d') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary" title="詳細表示">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-secondary" title="編集">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline" 
                                          onsubmit="return confirm('この商品を削除しますか？')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="削除">
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
                <div>
                    {{ $products->firstItem() }}~{{ $products->lastItem() }}件 / 全{{ $products->total() }}件
                </div>
                <div>
                    {{ $products->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-birthday-cake fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">商品が見つかりません</h5>
                <p class="text-muted">検索条件を変更するか、新しい商品を登録してください。</p>
            </div>
        @endif
    </div>
</div>
@endsection
