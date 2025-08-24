@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>新規顧客登録</h2>
    <div>
        <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>顧客一覧に戻る
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <form method="POST" action="{{ secure_url(route('customers.store', [], false)) }}">
            @csrf
            
            <!-- 顧客情報 -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">顧客情報</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">顧客名 *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" 
                               value="{{ old('name') }}" required placeholder="顧客名を入力してください">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">メールアドレス *</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" 
                               value="{{ old('email') }}" required placeholder="example@email.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">電話番号 *</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" 
                               value="{{ old('phone') }}" required placeholder="090-1234-5678">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="postal_code" class="form-label">郵便番号 *</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('postal_code') is-invalid @enderror" id="postal_code" name="postal_code" 
                                           value="{{ old('postal_code') }}" required placeholder="150-0001" maxlength="8">
                                    <button type="button" class="btn btn-outline-secondary" id="searchAddress">
                                        <i class="fas fa-search"></i> 住所検索
                                    </button>
                                </div>
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="prefecture" class="form-label">都道府県 *</label>
                                <input type="text" class="form-control @error('prefecture') is-invalid @enderror" id="prefecture" name="prefecture" 
                                       value="{{ old('prefecture') }}" required placeholder="東京都">
                                @error('prefecture')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">住所 *</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" 
                               value="{{ old('address') }}" required placeholder="渋谷区○○○ 1-2-3">
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">備考</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" 
                                  rows="3" placeholder="特別な注意事項があれば入力してください">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-2"></i>顧客を登録
                </button>
            </div>
        </form>
    </div>

    <!-- ヘルプ情報 -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">登録のヒント</h5>
            </div>
            <div class="card-body">
                <h6>顧客名について</h6>
                <p class="small text-muted">
                    姓名を分けて記入することをお勧めします。
                    例：「田中 太郎」
                </p>
                
                <h6>連絡先について</h6>
                <p class="small text-muted">
                    メールアドレスまたは電話番号のいずれかは入力することをお勧めします。
                    注文の確認や配送の連絡に使用されます。
                </p>
                
                <h6>住所について</h6>
                <p class="small text-muted">
                    配送が必要な注文の場合、正確な住所の入力が必要です。
                    郵便番号から自動入力される場合もあります。
                </p>
                
                <h6>備考について</h6>
                <p class="small text-muted">
                    アレルギー情報や特別なご要望があれば記入してください。
                    注文時に参考にされます。
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const postalCodeInput = document.getElementById('postal_code');
    const prefectureInput = document.getElementById('prefecture');
    const addressInput = document.getElementById('address');
    const searchButton = document.getElementById('searchAddress');

    // 郵便番号のフォーマット
    postalCodeInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^\d]/g, '');
        if (value.length >= 3) {
            value = value.slice(0, 3) + '-' + value.slice(3);
        }
        e.target.value = value;
    });

    // 住所検索ボタンのクリックイベント
    searchButton.addEventListener('click', function() {
        searchAddress();
    });

    // 郵便番号入力時の自動検索（7桁入力後）
    postalCodeInput.addEventListener('input', function(e) {
        const value = e.target.value.replace(/[^\d]/g, '');
        if (value.length === 7) {
            searchAddress();
        }
    });

    // 住所検索関数
    function searchAddress() {
        const postalCode = postalCodeInput.value.replace(/[^\d]/g, '');
        
        if (postalCode.length !== 7) {
            alert('郵便番号は7桁で入力してください。');
            return;
        }

        searchButton.disabled = true;
        searchButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> 検索中...';

        // 郵便番号検索APIを使用
        fetch(`https://zipcloud.ibsnet.co.jp/api/search?zipcode=${postalCode}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === 200 && data.results && data.results.length > 0) {
                    const result = data.results[0];
                    prefectureInput.value = result.address1; // 都道府県
                    addressInput.value = result.address2 + result.address3; // 市区町村 + 町域
                } else {
                    alert('該当する住所が見つかりませんでした。');
                }
            })
            .catch(error => {
                console.error('住所検索エラー:', error);
                alert('住所検索中にエラーが発生しました。');
            })
            .finally(() => {
                searchButton.disabled = false;
                searchButton.innerHTML = '<i class="fas fa-search"></i> 住所検索';
            });
    }
});
</script>
@endsection
