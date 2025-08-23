@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>顧客編集</h2>
    <div>
        <a href="{{ route('customers.show', $customer) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>顧客詳細に戻る
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <form method="POST" action="{{ route('customers.update', $customer) }}">
            @csrf
            @method('PUT')
            
            <!-- 顧客情報 -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">顧客情報</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">顧客名 *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                               value="{{ old('name', $customer->name) }}" required placeholder="顧客名を入力してください">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">メールアドレス</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" 
                               value="{{ old('email', $customer->email) }}" placeholder="example@email.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">電話番号</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" 
                               value="{{ old('phone', $customer->phone) }}" placeholder="090-1234-5678">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="postal_code" class="form-label">郵便番号</label>
                                <input type="text" class="form-control @error('postal_code') is-invalid @enderror" id="postal_code" name="postal_code" 
                                       value="{{ old('postal_code', $customer->postal_code) }}" placeholder="150-0001">
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="prefecture" class="form-label">都道府県</label>
                                <input type="text" class="form-control @error('prefecture') is-invalid @enderror" id="prefecture" name="prefecture" 
                                       value="{{ old('prefecture', $customer->prefecture) }}" placeholder="東京都">
                                @error('prefecture')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">住所</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" 
                               value="{{ old('address', $customer->address) }}" placeholder="渋谷区○○○ 1-2-3">
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">備考</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" 
                                  rows="3" placeholder="特別な注意事項があれば入力してください">{{ old('notes', $customer->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-2"></i>顧客を更新
                </button>
            </div>
        </form>
    </div>

    <!-- 現在の顧客情報 -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">現在の顧客情報</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">顧客番号</label>
                    <p class="mb-0">{{ $customer->customer_number }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">顧客名</label>
                    <p class="mb-0">{{ $customer->name }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">メールアドレス</label>
                    <p class="mb-0">
                        @if($customer->email)
                            {{ $customer->email }}
                        @else
                            <span class="text-muted">未登録</span>
                        @endif
                    </p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">電話番号</label>
                    <p class="mb-0">
                        @if($customer->phone)
                            {{ $customer->phone }}
                        @else
                            <span class="text-muted">未登録</span>
                        @endif
                    </p>
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
                
                <div class="mb-3">
                    <label class="form-label fw-bold">登録日</label>
                    <p class="mb-0">{{ $customer->created_at->format('Y年m月d日') }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">更新日</label>
                    <p class="mb-0">{{ $customer->updated_at->format('Y年m月d日') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
