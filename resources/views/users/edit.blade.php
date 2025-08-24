@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">ユーザー編集</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">名前 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">メールアドレス <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">パスワード</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="変更する場合のみ入力">
                            <small class="form-text text-muted">変更しない場合は空欄のままにしてください</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">パスワード確認</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="変更する場合のみ入力">
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">ロール <span class="text-danger">*</span></label>
                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                <option value="">選択してください</option>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>管理者</option>
                                <option value="store" {{ old('role', $user->role) === 'store' ? 'selected' : '' }}>店舗スタッフ</option>
                                <option value="manufacturing" {{ old('role', $user->role) === 'manufacturing' ? 'selected' : '' }}>製造部門</option>
                                <option value="logistics" {{ old('role', $user->role) === 'logistics' ? 'selected' : '' }}>物流部門</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3" id="department_field" style="display: {{ old('role', $user->role) === 'manufacturing' ? 'block' : 'none' }};">
                            <label for="department_id" class="form-label">部門 <span class="text-danger">*</span></label>
                            <select class="form-select @error('department_id') is-invalid @enderror" id="department_id" name="department_id">
                                <option value="">選択してください</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('department_id', $user->department_id) == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('users.show', $user) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> 戻る
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> 更新
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role');
    const departmentField = document.getElementById('department_field');
    const departmentSelect = document.getElementById('department_id');

    function toggleDepartmentField() {
        if (roleSelect.value === 'manufacturing') {
            departmentField.style.display = 'block';
            departmentSelect.required = true;
        } else {
            departmentField.style.display = 'none';
            departmentSelect.required = false;
            departmentSelect.value = '';
        }
    }

    roleSelect.addEventListener('change', toggleDepartmentField);
    
    // 初期状態を設定
    toggleDepartmentField();
});
</script>
@endsection
