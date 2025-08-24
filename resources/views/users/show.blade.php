@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">ユーザー詳細</h4>
                    <div>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> 編集
                        </a>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> 戻る
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>基本情報</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">ID:</th>
                                    <td>{{ $user->id }}</td>
                                </tr>
                                <tr>
                                    <th>名前:</th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th>メールアドレス:</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>ロール:</th>
                                    <td>
                                        <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'store' ? 'primary' : ($user->role === 'manufacturing' ? 'warning' : 'info')) }}">
                                            {{ $user->role === 'admin' ? '管理者' : ($user->role === 'store' ? '店舗スタッフ' : ($user->role === 'manufacturing' ? '製造部門' : '物流部門')) }}
                                        </span>
                                    </td>
                                </tr>
                                @if($user->role === 'manufacturing' && $user->department)
                                <tr>
                                    <th>所属部門:</th>
                                    <td>
                                        <span class="badge bg-secondary">{{ $user->department->name }}</span>
                                    </td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>アカウント情報</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">作成日:</th>
                                    <td>{{ $user->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>更新日:</th>
                                    <td>{{ $user->updated_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>最終ログイン:</th>
                                    <td>{{ $user->last_login_at ?? '未ログイン' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($user->id !== auth()->id())
                    <div class="mt-4">
                        <h5>危険な操作</h5>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('本当にこのユーザーを削除しますか？この操作は取り消せません。')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> ユーザーを削除
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
