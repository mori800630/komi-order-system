<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #8B4513;
            --secondary-color: #D2B48C;
            --accent-color: #FF6B35;
            --success-color: #28a745;
            --light-bg: #F5F5DC;
        }

        body {
            background-color: var(--light-bg);
            font-family: 'Hiragino Kaku Gothic ProN', 'Yu Gothic', sans-serif;
        }

        .sidebar {
            background-color: var(--primary-color);
            min-height: 100vh;
            color: white;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            margin: 0.25rem 0;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .sidebar .nav-link i {
            width: 20px;
            margin-right: 0.5rem;
        }

        .main-content {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #6B3410;
            border-color: #6B3410;
        }

        .btn-success {
            background-color: var(--success-color);
            border-color: var(--success-color);
        }

        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .table th {
            background-color: #f8f9fa;
            border-top: none;
        }

        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-order-received { 
            background-color: #ffebee; 
            color: #c62828; 
            border: 2px solid #f44336;
            font-weight: bold;
            animation: pulse 2s infinite;
        }
        .status-manufacturing { background-color: #fff3e0; color: #f57c00; }
        .status-packaging { background-color: #f3e5f5; color: #7b1fa2; }
        .status-in-transit { background-color: #e8f5e8; color: #388e3c; }
        .status-delivered { background-color: #e8f5e8; color: #2e7d32; }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(244, 67, 54, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(244, 67, 54, 0); }
            100% { box-shadow: 0 0 0 0 rgba(244, 67, 54, 0); }
        }

        .department-tag {
            background-color: var(--secondary-color);
            color: var(--primary-color);
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            margin: 0.125rem;
        }

        .btn-xs {
            padding: 0.125rem 0.25rem;
            font-size: 0.75rem;
            line-height: 1.2;
        }

        .order-summary {
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            padding: 1rem;
        }

        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- サイドバー -->
            <div class="col-md-3 col-lg-2 px-0">
                <div class="sidebar p-3">
                    <div class="mb-4">
                        <h4 class="mb-1">Komi BAKERY</h4>
                        <p class="mb-1 small">コミベーカリー</p>
                        <p class="mb-0 small">注文管理システム</p>
                    </div>

                    @auth
                    <div class="mb-3">
                        <p class="mb-1 small">管理者アカウント</p>
                        <p class="mb-0 small"><i class="fas fa-user"></i> {{ auth()->user()->name }}</p>
                    </div>
                    @endauth

                    <nav class="nav flex-column">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> ダッシュボード
                        </a>
                        <a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{ route('orders.index') }}">
                            <i class="fas fa-shopping-cart"></i> 注文管理
                        </a>
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                            <i class="fas fa-birthday-cake"></i> 商品管理
                        </a>
                        <a class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}" href="{{ route('customers.index') }}">
                            <i class="fas fa-users"></i> 顧客管理
                        </a>

                        @if(auth()->user()->isAdmin() || auth()->user()->isManufacturing())
                        <div class="mt-3">
                            <p class="small mb-2">部門別画面</p>
                            @foreach(\App\Models\Department::where('is_active', true)->get() as $department)
                                @if(auth()->user()->isAdmin() || auth()->user()->department_id == $department->id)
                                <a class="nav-link {{ request()->routeIs('department.orders') && request()->route('department')->id == $department->id ? 'active' : '' }}" 
                                   href="{{ route('department.orders', $department) }}">
                                    <i class="fas fa-industry"></i> {{ $department->name }}
                                </a>
                                @endif
                            @endforeach
                        </div>
                        @endif

                        @if(auth()->user()->isAdmin())
                        <div class="mt-3">
                            <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                                <i class="fas fa-user-cog"></i> ユーザー管理
                            </a>
                        </div>
                        @endif

                        <div class="mt-auto">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                                    <i class="fas fa-sign-out-alt"></i> ログアウト
                                </button>
                            </form>
                        </div>
                    </nav>
                </div>
            </div>

            <!-- メインコンテンツ -->
            <div class="col-md-9 col-lg-10">
                <div class="p-4">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
