@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>商品編集</h2>
    <div>
        <a href="{{ route('products.show', $product) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>商品詳細に戻る
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <form method="POST" action="{{ secure_url(route('products.update', $product, false)) }}">
            @csrf
            @method('PUT')
            
            <!-- 商品情報 -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">商品情報</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">商品名 *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                               value="{{ old('name', $product->name) }}" required placeholder="商品名を入力してください">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="name_kana" class="form-label">商品名 (ふりがな)</label>
                        <input type="text" class="form-control @error('name_kana') is-invalid @enderror" id="name_kana" name="name_kana" 
                               value="{{ old('name_kana', $product->name_kana) }}" placeholder="商品名のふりがなを入力してください">
                        @error('name_kana')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="department_id" class="form-label">製造部門 *</label>
                                <select class="form-select @error('department_id') is-invalid @enderror" id="department_id" name="department_id" required>
                                    <option value="">部門を選択してください</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ old('department_id', $product->department_id) == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">販売ステータス *</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="">ステータスを選択してください</option>
                                    <option value="pre_sale" {{ old('status', $product->status) == 'pre_sale' ? 'selected' : '' }}>販売前</option>
                                    <option value="on_sale" {{ old('status', $product->status) == 'on_sale' ? 'selected' : '' }}>販売中</option>
                                    <option value="discontinued" {{ old('status', $product->status) == 'discontinued' ? 'selected' : '' }}>販売終了</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">商品説明</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" 
                                  rows="3" placeholder="商品の説明を入力してください">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">価格 *</label>
                                <div class="input-group">
                                    <span class="input-group-text">¥</span>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" 
                                           value="{{ old('price', $product->price) }}" required min="0" step="1" placeholder="0">
                                </div>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">梱包物流</label>
                                <div class="packaging-radio-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="requires_packaging" 
                                               id="requires_packaging_1" value="1" {{ old('requires_packaging', $product->requires_packaging) == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="requires_packaging_1">対象</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="requires_packaging" 
                                               id="requires_packaging_0" value="0" {{ old('requires_packaging', $product->requires_packaging) == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="requires_packaging_0">対象外</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">デコレーション</label>
                                <div class="decoration-radio-group">
                                    <div class="form-check">
                                        <input class="form-check-input @error('decoration') is-invalid @enderror" type="radio" 
                                               name="decoration" id="decoration_available" value="available" {{ old('decoration', $product->decoration) == 'available' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="decoration_available">可</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input @error('decoration') is-invalid @enderror" type="radio" 
                                               name="decoration" id="decoration_unavailable" value="unavailable" {{ old('decoration', $product->decoration) == 'unavailable' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="decoration_unavailable">不可</label>
                                    </div>
                                </div>
                                @error('decoration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">備考</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" 
                                  rows="3" placeholder="特別な注意事項があれば入力してください">{{ old('notes', $product->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-2"></i>商品を更新
                </button>
            </div>
        </form>
    </div>

    <!-- 現在の商品情報 -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">現在の商品情報</h5>
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
                
                <div class="mb-3">
                    <label class="form-label fw-bold">価格</label>
                    <p class="mb-0">¥{{ number_format($product->price) }}</p>
                </div>
                
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
                
                @if($product->description)
                <div class="mb-3">
                    <label class="form-label fw-bold">商品説明</label>
                    <p class="mb-0">{{ $product->description }}</p>
                </div>
                @endif
                
                @if($product->notes)
                <div class="mb-3">
                    <label class="form-label fw-bold">備考</label>
                    <p class="mb-0">{{ $product->notes }}</p>
                </div>
                @endif
                
                <div class="mb-3">
                    <label class="form-label fw-bold">登録日</label>
                    <p class="mb-0">{{ $product->created_at->format('Y年m月d日') }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">更新日</label>
                    <p class="mb-0">{{ $product->updated_at->format('Y年m月d日') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
