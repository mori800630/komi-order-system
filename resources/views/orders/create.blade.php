@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>新規注文登録</h2>
    <div>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>注文一覧に戻る
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <form method="POST" action="{{ route('orders.store') }}" id="orderForm">
            @csrf
            
            <!-- 注文ステータス -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">注文ステータス</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">現在のステータス</label>
                        <p class="mb-0">
                            <span class="badge bg-primary">注文受付</span>
                        </p>
                        <input type="hidden" name="order_status_id" value="{{ $orderStatuses->where('code', 'order_received')->first()->id }}">
                    </div>
                </div>
            </div>

            <!-- 注文情報 -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">注文情報</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="order_source" class="form-label">注文ソース(受注経路) *</label>
                                <select class="form-select @error('order_source') is-invalid @enderror" id="order_source" name="order_source" required>
                                    <option value="">選択してください</option>
                                    <option value="phone" {{ old('order_source') == 'phone' ? 'selected' : '' }}>電話注文</option>
                                    <option value="store" {{ old('order_source') == 'store' ? 'selected' : '' }}>来店注文</option>
                                    <option value="pickup_site" {{ old('order_source') == 'pickup_site' ? 'selected' : '' }}>店頭受け取り予約サイト</option>
                                    <option value="delivery_site" {{ old('order_source') == 'delivery_site' ? 'selected' : '' }}>お取り寄せ専用サイト</option>
                                    <option value="email" {{ old('order_source') == 'email' ? 'selected' : '' }}>メール注文</option>
                                    <option value="event" {{ old('order_source') == 'event' ? 'selected' : '' }}>催事・イベント</option>
                                    <option value="other" {{ old('order_source') == 'other' ? 'selected' : '' }}>その他</option>
                                </select>
                                @error('order_source')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="delivery_method" class="form-label">受け取り方法 *</label>
                                <select class="form-select @error('delivery_method') is-invalid @enderror" id="delivery_method" name="delivery_method" required>
                                    <option value="">選択してください</option>
                                    <option value="pickup" {{ old('delivery_method') == 'pickup' ? 'selected' : '' }}>店頭受け取り</option>
                                    <option value="delivery" {{ old('delivery_method') == 'delivery' ? 'selected' : '' }}>お取り寄せ</option>
                                </select>
                                @error('delivery_method')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- 店頭受け取りの場合の入力項目 -->
                    <div id="pickup_info" class="row" style="display: none;">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pickup_date" class="form-label">受け取り日 *</label>
                                <input type="date" class="form-control @error('pickup_date') is-invalid @enderror" 
                                       id="pickup_date" name="pickup_date" value="{{ old('pickup_date') }}">
                                @error('pickup_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pickup_time" class="form-label">受け取り時間 *</label>
                                <select class="form-select @error('pickup_time') is-invalid @enderror" id="pickup_time" name="pickup_time">
                                    <option value="">選択してください</option>
                                    @for($hour = 7; $hour <= 19; $hour++)
                                        <option value="{{ sprintf('%02d:00', $hour) }}" {{ old('pickup_time') == sprintf('%02d:00', $hour) ? 'selected' : '' }}>
                                            {{ $hour }}:00
                                        </option>
                                    @endfor
                                </select>
                                @error('pickup_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 顧客情報 -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">顧客情報</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="customer_id" class="form-label">顧客選択</label>
                        <select class="form-select" id="customer_id" name="customer_id">
                            <option value="">新規顧客</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}({{ $customer->customer_number }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- 顧客情報表示・編集エリア -->
                    <div id="customer_info" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_name" class="form-label">お名前 *</label>
                                    <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_phone" class="form-label">電話番号</label>
                                    <input type="text" class="form-control" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_email" class="form-label">メールアドレス</label>
                                    <input type="email" class="form-control" id="customer_email" name="customer_email" value="{{ old('customer_email') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_postal_code" class="form-label">郵便番号</label>
                                    <input type="text" class="form-control" id="customer_postal_code" name="customer_postal_code" value="{{ old('customer_postal_code') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_prefecture" class="form-label">都道府県</label>
                                    <input type="text" class="form-control" id="customer_prefecture" name="customer_prefecture" value="{{ old('customer_prefecture') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="customer_address" class="form-label">住所</label>
                                    <input type="text" class="form-control" id="customer_address" name="customer_address" value="{{ old('customer_address') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 送付先情報 -->
            <div class="card mb-4" id="delivery_info" style="display: none;">
                <div class="card-header">
                    <h5 class="mb-0">送付先情報</h5>
                    <small class="text-muted">顧客情報と異なる場合はこちらに入力してください</small>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="same_as_customer" checked>
                            <label class="form-check-label" for="same_as_customer">
                                顧客情報と同じ
                            </label>
                        </div>
                    </div>
                    
                    <div id="delivery_form" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="delivery_name" class="form-label">お名前 *</label>
                                    <input type="text" class="form-control" id="delivery_name" name="delivery_name" value="{{ old('delivery_name') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="delivery_phone" class="form-label">電話番号 *</label>
                                    <input type="text" class="form-control" id="delivery_phone" name="delivery_phone" value="{{ old('delivery_phone') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="delivery_postal_code" class="form-label">郵便番号 *</label>
                                    <input type="text" class="form-control" id="delivery_postal_code" name="delivery_postal_code" value="{{ old('delivery_postal_code') }}">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="delivery_prefecture" class="form-label">都道府県 *</label>
                                    <input type="text" class="form-control" id="delivery_prefecture" name="delivery_prefecture" value="{{ old('delivery_prefecture') }}">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="delivery_address" class="form-label">住所 *</label>
                            <input type="text" class="form-control" id="delivery_address" name="delivery_address" value="{{ old('delivery_address') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 商品情報 -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">商品情報</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#productModal">
                        <i class="fas fa-plus me-1"></i>商品追加
                    </button>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="department_filter" class="form-label">部門フィルター</label>
                            <select class="form-select" id="department_filter">
                                <option value="">全部門</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                <div class="card-body">
                    <div id="order-items">
                        <!-- 商品が選択されるとここに追加される -->
                    </div>
                    
                    <div class="text-end">
                        <h5>合計金額: <span id="total-amount">¥0</span></h5>
                    </div>
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-2"></i>注文を登録
                </button>
            </div>
        </form>
    </div>

    <!-- 現在の注文情報 -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">現在の注文情報</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">注文番号</label>
                    <p class="mb-0">自動採番</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">注文ステータス</label>
                    <p class="mb-0">
                        <span class="badge bg-primary">注文受付</span>
                    </p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">注文日</label>
                    <p class="mb-0">{{ now()->format('Y年m月d日 H:i') }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">注文元</label>
                    <p class="mb-0" id="order-source-display">未選択</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">受け取り方法</label>
                    <p class="mb-0" id="delivery-method-display">未選択</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 商品選択モーダル -->
<div class="modal fade" id="productModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">商品選択</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="productSearch" placeholder="商品名で検索...">
                    </div>
                    <div class="col-md-6">
                        <select class="form-select" id="modalDepartmentFilter">
                            <option value="">全部門</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>商品名</th>
                                <th>製造部門</th>
                                <th>価格</th>
                                <th>アクション</th>
                            </tr>
                        </thead>
                        <tbody id="productList">
                            @foreach($products as $product)
                            <tr data-department-id="{{ $product->department_id }}">
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->department->name }}</td>
                                <td>¥{{ number_format($product->price) }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary select-product" 
                                            data-product-id="{{ $product->id }}" 
                                            data-product-name="{{ $product->name }}" 
                                            data-product-price="{{ $product->price }}">
                                        選択
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deliveryMethod = document.getElementById('delivery_method');
    const pickupInfo = document.getElementById('pickup_info');
    const deliveryInfo = document.getElementById('delivery_info');
    const orderSource = document.getElementById('order_source');
    const customerSelect = document.getElementById('customer_id');
    const sameAsCustomer = document.getElementById('same_as_customer');
    const deliveryForm = document.getElementById('delivery_form');

    // 受け取り方法の変更
    deliveryMethod.addEventListener('change', function() {
        if (this.value === 'pickup') {
            pickupInfo.style.display = 'block';
            deliveryInfo.style.display = 'none';
        } else if (this.value === 'delivery') {
            pickupInfo.style.display = 'none';
            deliveryInfo.style.display = 'block';
        } else {
            pickupInfo.style.display = 'none';
            deliveryInfo.style.display = 'none';
        }
        
        // 表示更新
        document.getElementById('delivery-method-display').textContent = this.value === 'pickup' ? '店頭受け取り' : 
                                                                       this.value === 'delivery' ? 'お取り寄せ' : '未選択';
    });

    // 注文ソースの変更
    orderSource.addEventListener('change', function() {
        if (this.value === 'delivery_site') {
            deliveryInfo.style.display = 'none';
            deliveryInfo.querySelectorAll('input').forEach(input => {
                input.disabled = true;
            });
        } else {
            deliveryInfo.querySelectorAll('input').forEach(input => {
                input.disabled = false;
            });
        }
        
        // 表示更新
        const sourceText = {
            'phone': '電話注文',
            'store': '来店注文',
            'pickup_site': '店頭受け取り予約サイト',
            'delivery_site': 'お取り寄せ専用サイト',
            'email': 'メール注文',
            'event': '催事・イベント',
            'other': 'その他'
        };
        document.getElementById('order-source-display').textContent = sourceText[this.value] || '未選択';
    });

    // 顧客選択時の処理
    customerSelect.addEventListener('change', function() {
        const selectedCustomerId = this.value;
        const customerInfo = document.getElementById('customer_info');
        
        if (selectedCustomerId) {
            // 既存顧客を選択した場合
            fetch(`/customers/${selectedCustomerId}`)
                .then(response => response.json())
                .then(customer => {
                    // 顧客情報を表示・編集可能にする
                    customerInfo.style.display = 'block';
                    
                    // 各項目に自動入力
                    document.getElementById('customer_name').value = customer.name || '';
                    document.getElementById('customer_phone').value = customer.phone || '';
                    document.getElementById('customer_email').value = customer.email || '';
                    document.getElementById('customer_postal_code').value = customer.postal_code || '';
                    document.getElementById('customer_prefecture').value = customer.prefecture || '';
                    document.getElementById('customer_address').value = customer.address || '';
                    
                    // お取り寄せの場合、送付先情報も自動セット
                    if (deliveryMethod.value === 'delivery') {
                        updateDeliveryInfo();
                    }
                })
                .catch(error => {
                    console.error('顧客情報の取得に失敗しました:', error);
                });
        } else {
            // 新規顧客の場合
            customerInfo.style.display = 'block';
            // フィールドをクリア
            document.getElementById('customer_name').value = '';
            document.getElementById('customer_phone').value = '';
            document.getElementById('customer_email').value = '';
            document.getElementById('customer_postal_code').value = '';
            document.getElementById('customer_prefecture').value = '';
            document.getElementById('customer_address').value = '';
        }
    });

    // 顧客情報と同じチェックボックスの処理
    sameAsCustomer.addEventListener('change', function() {
        if (this.checked) {
            deliveryForm.style.display = 'none';
            updateDeliveryInfo();
        } else {
            deliveryForm.style.display = 'block';
        }
    });

    // 送付先情報を顧客情報と同じに更新
    function updateDeliveryInfo() {
        if (sameAsCustomer.checked) {
            document.getElementById('delivery_name').value = document.getElementById('customer_name').value;
            document.getElementById('delivery_phone').value = document.getElementById('customer_phone').value;
            document.getElementById('delivery_postal_code').value = document.getElementById('customer_postal_code').value;
            document.getElementById('delivery_prefecture').value = document.getElementById('customer_prefecture').value;
            document.getElementById('delivery_address').value = document.getElementById('customer_address').value;
        }
    }

    // 顧客情報が変更された時の処理
    document.getElementById('customer_name').addEventListener('input', updateDeliveryInfo);
    document.getElementById('customer_phone').addEventListener('input', updateDeliveryInfo);
    document.getElementById('customer_postal_code').addEventListener('input', updateDeliveryInfo);
    document.getElementById('customer_prefecture').addEventListener('input', updateDeliveryInfo);
    document.getElementById('customer_address').addEventListener('input', updateDeliveryInfo);

    // 商品検索機能
    const productSearch = document.getElementById('productSearch');
    const productList = document.getElementById('productList');
    const modalDepartmentFilter = document.getElementById('modalDepartmentFilter');
    
    function filterProducts() {
        const searchTerm = productSearch.value.toLowerCase();
        const selectedDepartment = modalDepartmentFilter.value;
        const rows = productList.getElementsByTagName('tr');
        
        for (let row of rows) {
            const productName = row.cells[0].textContent.toLowerCase();
            const departmentName = row.cells[1].textContent;
            const departmentId = row.dataset.departmentId;
            
            const matchesSearch = productName.includes(searchTerm);
            const matchesDepartment = !selectedDepartment || departmentId == selectedDepartment;
            
            if (matchesSearch && matchesDepartment) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    }
    
    productSearch.addEventListener('input', filterProducts);
    modalDepartmentFilter.addEventListener('change', filterProducts);
    
    // 商品選択
    document.querySelectorAll('.select-product').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const productName = this.dataset.productName;
            const productPrice = this.dataset.productPrice;
            
            addOrderItem(productId, productName, productPrice);
            
            // モーダルを閉じる
            const modal = bootstrap.Modal.getInstance(document.getElementById('productModal'));
            modal.hide();
        });
    });
    
    // 商品追加
    function addOrderItem(productId, productName, productPrice) {
        const orderItems = document.getElementById('order-items');
        const itemCount = orderItems.children.length;
        
        const itemHtml = `
            <div class="order-item border rounded p-3 mb-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">商品名</label>
                            <input type="text" class="form-control" value="${productName}" readonly>
                            <input type="hidden" name="products[]" value="${productId}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label class="form-label">単価</label>
                            <input type="number" class="form-control unit-price" name="prices[]" 
                                   value="${productPrice}" min="0" step="1" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label class="form-label">数量</label>
                            <input type="number" class="form-control quantity" name="quantities[]" 
                                   value="1" min="1" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label class="form-label">小計</label>
                            <input type="text" class="form-control subtotal" value="¥${Number(productPrice).toLocaleString()}" readonly>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-item">
                        <i class="fas fa-trash me-1"></i>削除
                    </button>
                </div>
            </div>
        `;
        
        orderItems.insertAdjacentHTML('beforeend', itemHtml);
        updateTotalAmount();
    }
    
    // 商品削除
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item') || e.target.closest('.remove-item')) {
            const item = e.target.closest('.order-item');
            item.remove();
            updateTotalAmount();
        }
    });
    
    // 小計計算
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('unit-price') || e.target.classList.contains('quantity')) {
            const item = e.target.closest('.order-item');
            const unitPrice = parseFloat(item.querySelector('.unit-price').value) || 0;
            const quantity = parseInt(item.querySelector('.quantity').value) || 0;
            const subtotal = unitPrice * quantity;
            
            item.querySelector('.subtotal').value = `¥${subtotal.toLocaleString()}`;
            updateTotalAmount();
        }
    });
    
    // 合計金額更新
    function updateTotalAmount() {
        const subtotals = document.querySelectorAll('.subtotal');
        let total = 0;
        
        subtotals.forEach(subtotal => {
            const value = subtotal.value.replace('¥', '').replace(',', '');
            total += parseFloat(value) || 0;
        });
        
        document.getElementById('total-amount').textContent = `¥${total.toLocaleString()}`;
    }

    // ページ読み込み時の初期化
    // 送付先情報フォームの初期状態を設定
    if (sameAsCustomer.checked) {
        deliveryForm.style.display = 'none';
    } else {
        deliveryForm.style.display = 'block';
    }
});
</script>
@endsection
