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
        <div class="card mb-4 @if($order->orderStatus->code === 'order_received') border-danger @endif">
            <div class="card-header @if($order->orderStatus->code === 'order_received') bg-danger text-white @endif">
                <h5 class="mb-0">
                    @if($order->orderStatus->code === 'order_received')
                        <i class="fas fa-exclamation-triangle me-2"></i>
                    @endif
                    注文情報
                    @if($order->orderStatus->code === 'order_received')
                        <span class="badge bg-warning text-dark ms-2">製造開始待ち</span>
                    @endif
                </h5>
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
                        <div class="mb-3 @if($order->orderStatus->code === 'order_received') border border-danger rounded p-3 bg-light @endif">
                            <label class="form-label fw-bold">
                                @if($order->orderStatus->code === 'order_received')
                                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                                @endif
                                注文ステータス
                                @if($order->orderStatus->code === 'order_received')
                                    <span class="badge bg-danger ms-2">製造開始待ち</span>
                                @endif
                            </label>
                            <p class="mb-0">
                                <span class="status-badge status-{{ $order->orderStatus->code }}">
                                    {{ $order->orderStatus->name }}
                                </span>
                            </p>
                            
                            <!-- ステータス遷移ボタン -->
                            @php
                                $availableTransitions = $order->getAvailableTransitions(auth()->user());
                            @endphp
                            @if($availableTransitions->count() > 0)
                                <div class="mt-2">
                                    @foreach($availableTransitions as $transition)
                                        <form action="{{ route('orders.update-status', $order) }}" method="POST" class="d-inline me-2">
                                            @csrf
                                            <input type="hidden" name="new_status_id" value="{{ $transition->to_status_id }}">
                                            <button type="submit" class="btn btn-sm btn-outline-primary" 
                                                    onclick="return confirm('ステータスを「{{ $transition->toStatus->name }}」に変更しますか？')"
                                                    title="{{ $transition->description }}">
                                                <i class="fas fa-arrow-right me-1"></i>{{ $transition->toStatus->name }}へ
                                            </button>
                                        </form>
                                        @if($transition->requires_all_departments_completed)
                                            @php
                                                $incompleteDepartments = $transition->getIncompleteDepartments($order);
                                            @endphp
                                            <div class="mt-1">
                                                @if($incompleteDepartments->count() > 0)
                                                    <small class="text-danger">
                                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                                        未完了の部門: {{ $incompleteDepartments->pluck('name')->implode(', ') }}
                                                    </small>
                                                @else
                                                    <small class="text-success">
                                                        <i class="fas fa-check-circle me-1"></i>
                                                        全製造部門の作業が完了しています
                                                    </small>
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
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
                            <div class="d-flex align-items-center">
                                <span class="me-2">
                                    @if($order->requires_packaging)
                                        <span class="badge bg-info">必要</span>
                                    @else
                                        <span class="badge bg-light text-dark">不要</span>
                                    @endif
                                </span>
                                <button type="button" class="btn btn-sm btn-outline-secondary" 
                                        data-bs-toggle="modal" data-bs-target="#packagingModal">
                                    <i class="fas fa-edit"></i> 変更
                                </button>
                            </div>
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
                                <td>
                                    @if($item->product->status === 'discontinued')
                                        <span class="text-decoration-line-through text-muted">{{ $item->product->name }}</span>
                                        <span class="badge bg-secondary ms-1">販売終了</span>
                                    @else
                                        {{ $item->product->name }}
                                    @endif
                                </td>
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

        <!-- 部門別製造ステータス -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">部門別製造ステータス</h5>
            </div>
            <div class="card-body">
                @php
                    $orderDepartments = $order->orderItems->pluck('product.department')->unique();
                @endphp
                
                @foreach($orderDepartments as $department)
                    @php
                        $deptStatus = $order->departmentStatuses()->where('department_id', $department->id)->first();
                        $currentStatus = $deptStatus ? $deptStatus->status : 'not_started';
                    @endphp
                    
                    <div class="border rounded p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0">{{ $department->name }}</h6>
                            <span class="badge {{ $deptStatus ? $deptStatus->status_badge_class : 'bg-secondary' }}">
                                {{ $deptStatus ? $deptStatus->status_text : '未開始' }}
                            </span>
                        </div>
                        
                        @if($deptStatus)
                            <div class="small text-muted mb-2">
                                @if($deptStatus->started_at)
                                    開始: {{ $deptStatus->started_at->format('Y-m-d H:i') }}
                                @endif
                                @if($deptStatus->completed_at)
                                    <br>完了: {{ $deptStatus->completed_at->format('Y-m-d H:i') }}
                                @endif
                            </div>
                        @endif
                        
                        <!-- 製造ステータス更新ボタン -->
                        @if(auth()->user()->isAdmin() || (auth()->user()->isManufacturing() && auth()->user()->department_id == $department->id))
                            <div class="btn-group btn-group-sm" role="group">
                                @if($currentStatus === 'not_started')
                                    <form action="{{ route('orders.update-department-status', $order) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="department_id" value="{{ $department->id }}">
                                        <input type="hidden" name="status" value="in_progress">
                                        <button type="submit" class="btn btn-warning btn-sm">
                                            <i class="fas fa-play me-1"></i>製造開始
                                        </button>
                                    </form>
                                @elseif($currentStatus === 'in_progress')
                                    <form action="{{ route('orders.update-department-status', $order) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="department_id" value="{{ $department->id }}">
                                        <input type="hidden" name="status" value="completed">
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-check me-1"></i>製造完了
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
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

<!-- 梱包物流変更モーダル -->
<div class="modal fade" id="packagingModal" tabindex="-1" style="z-index: 1060;">
    <div class="modal-dialog" style="z-index: 1070;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">梱包物流設定</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('orders.update-packaging', $order) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">梱包物流</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="requires_packaging" id="packaging_required" value="1" 
                                   {{ $order->requires_packaging ? 'checked' : '' }}>
                            <label class="form-check-label" for="packaging_required">
                                必要
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="requires_packaging" id="packaging_not_required" value="0" 
                                   {{ !$order->requires_packaging ? 'checked' : '' }}>
                            <label class="form-check-label" for="packaging_not_required">
                                不要
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                    <button type="submit" class="btn btn-primary">更新</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* モーダルのz-index設定 */
#packagingModal {
    z-index: 1060 !important;
}

#packagingModal .modal-dialog {
    z-index: 1070 !important;
}

/* バックドロップの設定（モーダルが開いている時のみ） */
.modal-backdrop {
    z-index: 1050 !important;
}

/* モーダルが開いている時のみpointer-eventsを無効化 */
.modal-open .modal-backdrop {
    pointer-events: none !important;
}

/* モーダル内のボタンはクリック可能にする */
#packagingModal .btn {
    pointer-events: auto !important;
}

/* モーダル以外の要素は通常通りクリック可能 */
body:not(.modal-open) * {
    pointer-events: auto !important;
}

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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ページ読み込み時にpointer-eventsを正常に設定
    document.querySelectorAll('*').forEach(element => {
        element.style.pointerEvents = '';
    });
    
    // 梱包物流設定モーダルの処理
    const packagingModal = document.getElementById('packagingModal');
    if (packagingModal) {
        // モーダルを開く際の処理
        const openPackagingModal = () => {
            const modal = new bootstrap.Modal(packagingModal, {
                backdrop: false, // バックドロップを無効化
                keyboard: false  // ESCキーで閉じない
            });
            modal.show();
            
            // バックドロップのz-indexを調整
            setTimeout(() => {
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.style.zIndex = '1050';
                    backdrop.style.pointerEvents = 'none';
                }
            }, 100);
        };
        
        // モーダルを閉じる関数
        const closePackagingModal = () => {
            try {
                const modal = bootstrap.Modal.getInstance(packagingModal);
                if (modal) {
                    modal.hide();
                } else {
                    packagingModal.style.display = 'none';
                    packagingModal.classList.remove('show');
                    document.body.classList.remove('modal-open');
                }
                
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.remove();
                }
                
                document.body.style.overflow = '';
                
                // モーダルが閉じられた後、すべての要素のpointer-eventsを復活
                document.querySelectorAll('*').forEach(element => {
                    if (!element.classList.contains('modal-backdrop')) {
                        element.style.pointerEvents = '';
                    }
                });
                
            } catch (error) {
                console.error('Error closing packaging modal:', error);
            }
        };
        
        // キャンセルボタンの処理
        const cancelButton = packagingModal.querySelector('.btn-secondary');
        if (cancelButton) {
            cancelButton.addEventListener('click', function(e) {
                e.preventDefault();
                closePackagingModal();
            });
        }
        
        // フォーム送信後の処理
        const packagingForm = packagingModal.querySelector('form');
        if (packagingForm) {
            packagingForm.addEventListener('submit', function() {
                // フォーム送信後にモーダルを閉じる
                setTimeout(() => {
                    closePackagingModal();
                }, 100);
            });
        }
    }
    
    // 梱包中への遷移ボタンを制御
    const packagingButtons = document.querySelectorAll('form[action*="update-status"] button[type="submit"]');
    
    packagingButtons.forEach(button => {
        const form = button.closest('form');
        const statusInput = form.querySelector('input[name="new_status_id"]');
        
        if (statusInput) {
            // 梱包中ステータスのIDを取得（実際のIDに置き換える必要があります）
            const packagingStatusId = '{{ \App\Models\OrderStatus::where("code", "packaging")->first()->id ?? "" }}';
            
            if (statusInput.value == packagingStatusId) {
                // 部門ステータスをチェック
                const departmentStatuses = @json($order->departmentStatuses->keyBy('department_id'));
                const orderDepartments = @json($order->orderItems->pluck('product.department')->unique('id'));
                
                let hasIncompleteDepartment = false;
                let incompleteDepartments = [];
                
                orderDepartments.forEach(dept => {
                    const deptStatus = departmentStatuses[dept.id];
                    if (!deptStatus || deptStatus.status !== 'completed') {
                        hasIncompleteDepartment = true;
                        incompleteDepartments.push(dept.name);
                    }
                });
                
                if (hasIncompleteDepartment) {
                    button.disabled = true;
                    button.classList.add('btn-secondary');
                    button.classList.remove('btn-outline-primary');
                    button.title = '未完了の部門があります: ' + incompleteDepartments.join(', ');
                    
                    // 警告メッセージを追加
                    const warningDiv = document.createElement('div');
                    warningDiv.className = 'mt-1';
                    warningDiv.innerHTML = '<small class="text-danger"><i class="fas fa-exclamation-triangle me-1"></i>未完了の部門があるため、梱包中に変更できません</small>';
                    form.parentNode.appendChild(warningDiv);
                }
            }
        }
    });
});
</script>
@endsection
