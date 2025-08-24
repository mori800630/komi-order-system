<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #D4A574;
            --secondary-color: #F5E6D3;
            --accent-color: #B8860B;
            --text-color: #5D4E37;
            --light-bg: rgba(255, 255, 255, 0.95);
            --border-color: #E8D5B7;
            --sidebar-bg: #8B4513;
            --sidebar-hover: #A0522D;
        }

        body {
            background: linear-gradient(135deg, #F5E6D3 0%, #E8D5B7 100%);
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', sans-serif;
            position: relative;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }

        /* 背景のパンくずパターン */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 20%, rgba(212, 165, 116, 0.1) 1px, transparent 1px),
                radial-gradient(circle at 80% 40%, rgba(212, 165, 116, 0.1) 1px, transparent 1px),
                radial-gradient(circle at 40% 80%, rgba(212, 165, 116, 0.1) 1px, transparent 1px),
                radial-gradient(circle at 90% 90%, rgba(212, 165, 116, 0.1) 1px, transparent 1px),
                radial-gradient(circle at 10% 60%, rgba(212, 165, 116, 0.1) 1px, transparent 1px),
                radial-gradient(circle at 70% 10%, rgba(212, 165, 116, 0.1) 1px, transparent 1px);
            background-size: 100px 100px, 150px 150px, 120px 120px, 80px 80px, 200px 200px, 180px 180px;
            pointer-events: none;
            z-index: 1;
        }

        /* フローティングアイコン */
        .floating-icon {
            position: fixed;
            color: rgba(212, 165, 116, 0.1);
            font-size: 1.5rem;
            animation: float 8s ease-in-out infinite;
            z-index: 1;
            pointer-events: none;
        }

        .floating-icon:nth-child(1) { top: 5%; left: 3%; animation-delay: 0s; }
        .floating-icon:nth-child(2) { top: 12%; right: 4%; animation-delay: 0.3s; }
        .floating-icon:nth-child(3) { bottom: 45%; left: 1%; animation-delay: 0.6s; }
        .floating-icon:nth-child(4) { bottom: 35%; right: 3%; animation-delay: 0.9s; }
        .floating-icon:nth-child(5) { top: 55%; left: 0.5%; animation-delay: 1.2s; }
        .floating-icon:nth-child(6) { top: 65%; right: 1%; animation-delay: 1.5s; }
        .floating-icon:nth-child(7) { top: 38%; left: 8%; animation-delay: 1.8s; }
        .floating-icon:nth-child(8) { top: 78%; right: 12%; animation-delay: 2.1s; }
        .floating-icon:nth-child(9) { top: 18%; left: 15%; animation-delay: 2.4s; }
        .floating-icon:nth-child(10) { top: 48%; right: 20%; animation-delay: 2.7s; }
        .floating-icon:nth-child(11) { bottom: 25%; left: 12%; animation-delay: 3s; }
        .floating-icon:nth-child(12) { top: 82%; left: 6%; animation-delay: 3.3s; }
        .floating-icon:nth-child(13) { top: 32%; right: 25%; animation-delay: 3.6s; }
        .floating-icon:nth-child(14) { bottom: 18%; right: 18%; animation-delay: 3.9s; }
        .floating-icon:nth-child(15) { top: 72%; left: 20%; animation-delay: 4.2s; }
        .floating-icon:nth-child(16) { top: 28%; left: 30%; animation-delay: 4.5s; }
        .floating-icon:nth-child(17) { bottom: 48%; right: 30%; animation-delay: 4.8s; }
        .floating-icon:nth-child(18) { top: 88%; right: 6%; animation-delay: 5.1s; }
        .floating-icon:nth-child(19) { top: 42%; left: 35%; animation-delay: 5.4s; }
        .floating-icon:nth-child(20) { bottom: 12%; left: 25%; animation-delay: 5.7s; }
        .floating-icon:nth-child(21) { top: 8%; left: 7%; animation-delay: 6s; }
        .floating-icon:nth-child(22) { top: 22%; right: 6%; animation-delay: 6.3s; }
        .floating-icon:nth-child(23) { bottom: 42%; left: 4%; animation-delay: 6.6s; }
        .floating-icon:nth-child(24) { bottom: 32%; right: 7%; animation-delay: 6.9s; }
        .floating-icon:nth-child(25) { top: 52%; left: 2%; animation-delay: 7.2s; }
        .floating-icon:nth-child(26) { top: 62%; right: 3%; animation-delay: 7.5s; }
        .floating-icon:nth-child(27) { top: 36%; left: 10%; animation-delay: 7.8s; }
        .floating-icon:nth-child(28) { top: 76%; right: 14%; animation-delay: 0.2s; }
        .floating-icon:nth-child(29) { top: 16%; left: 18%; animation-delay: 0.5s; }
        .floating-icon:nth-child(30) { top: 46%; right: 22%; animation-delay: 0.8s; }
        .floating-icon:nth-child(31) { bottom: 22%; left: 15%; animation-delay: 1.1s; }
        .floating-icon:nth-child(32) { top: 84%; left: 9%; animation-delay: 1.4s; }
        .floating-icon:nth-child(33) { top: 34%; right: 28%; animation-delay: 1.7s; }
        .floating-icon:nth-child(34) { bottom: 16%; right: 20%; animation-delay: 2s; }
        .floating-icon:nth-child(35) { top: 74%; left: 22%; animation-delay: 2.3s; }
        .floating-icon:nth-child(36) { top: 26%; left: 32%; animation-delay: 2.6s; }
        .floating-icon:nth-child(37) { bottom: 46%; right: 32%; animation-delay: 2.9s; }
        .floating-icon:nth-child(38) { top: 86%; right: 10%; animation-delay: 3.2s; }
        .floating-icon:nth-child(39) { top: 44%; left: 38%; animation-delay: 3.5s; }
        .floating-icon:nth-child(40) { bottom: 14%; left: 28%; animation-delay: 3.8s; }
        .floating-icon:nth-child(41) { top: 6%; left: 11%; animation-delay: 4.1s; }
        .floating-icon:nth-child(42) { top: 24%; right: 9%; animation-delay: 4.4s; }
        .floating-icon:nth-child(43) { bottom: 44%; left: 6%; animation-delay: 4.7s; }
        .floating-icon:nth-child(44) { bottom: 34%; right: 11%; animation-delay: 5s; }
        .floating-icon:nth-child(45) { top: 54%; left: 3%; animation-delay: 5.3s; }
        .floating-icon:nth-child(46) { top: 64%; right: 5%; animation-delay: 5.6s; }
        .floating-icon:nth-child(47) { top: 37%; left: 14%; animation-delay: 5.9s; }
        .floating-icon:nth-child(48) { top: 77%; right: 16%; animation-delay: 6.2s; }
        .floating-icon:nth-child(49) { top: 17%; left: 22%; animation-delay: 6.5s; }
        .floating-icon:nth-child(50) { top: 47%; right: 26%; animation-delay: 6.8s; }
        .floating-icon:nth-child(51) { bottom: 24%; left: 18%; animation-delay: 7.1s; }
        .floating-icon:nth-child(52) { top: 83%; left: 12%; animation-delay: 7.4s; }
        .floating-icon:nth-child(53) { top: 33%; right: 32%; animation-delay: 7.7s; }
        .floating-icon:nth-child(54) { bottom: 19%; right: 24%; animation-delay: 0.1s; }
        .floating-icon:nth-child(55) { top: 73%; left: 26%; animation-delay: 0.4s; }
        .floating-icon:nth-child(56) { top: 27%; left: 36%; animation-delay: 0.7s; }
        .floating-icon:nth-child(57) { bottom: 47%; right: 36%; animation-delay: 1s; }
        .floating-icon:nth-child(58) { top: 87%; right: 12%; animation-delay: 1.3s; }
        .floating-icon:nth-child(59) { top: 43%; left: 42%; animation-delay: 1.6s; }
        .floating-icon:nth-child(60) { bottom: 13%; left: 32%; animation-delay: 1.9s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-15px) rotate(5deg); }
        }

        .sidebar {
            background-color: var(--sidebar-bg);
            min-height: 100vh;
            color: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.9);
            padding: 0.75rem 1rem;
            border-radius: 8px;
            margin: 0.25rem 0;
            transition: all 0.3s ease;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: var(--sidebar-hover);
            color: white;
            transform: translateX(5px);
        }

        .sidebar .nav-link i {
            width: 20px;
            margin-right: 0.5rem;
        }

        .main-content {
            background-color: var(--light-bg);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid var(--border-color);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(212, 165, 116, 0.3);
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #218838;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }

        .card {
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            background-color: var(--light-bg);
        }

        .table th {
            background-color: var(--secondary-color);
            border-top: none;
            color: var(--text-color);
            font-weight: 600;
        }

        .table td {
            color: var(--text-color);
        }

        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-order-received { 
            background: linear-gradient(45deg, #ff1744, #d50000);
            color: white; 
            border: 3px solid #ff1744;
            font-weight: bold;
            font-size: 1.1em;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
            animation: urgent-pulse 1.5s infinite;
            position: relative;
            overflow: hidden;
        }
        
        .status-order-received::before {
            content: "⚠️ 製造開始待ち";
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            background: linear-gradient(45deg, #ff1744, #ff5722);
            color: white;
            font-size: 0.7em;
            padding: 2px 4px;
            text-align: center;
            font-weight: bold;
            border-radius: 0.25rem 0.25rem 0 0;
        }
        
        @keyframes urgent-pulse {
            0% { 
                box-shadow: 0 0 0 0 rgba(255, 23, 68, 0.8);
                transform: scale(1);
            }
            50% { 
                box-shadow: 0 0 0 15px rgba(255, 23, 68, 0.3);
                transform: scale(1.05);
            }
            100% { 
                box-shadow: 0 0 0 0 rgba(255, 23, 68, 0.8);
                transform: scale(1);
            }
        }
        
        .status-manufacturing { background-color: #fff3e0; color: #f57c00; }
        .status-packaging { background-color: #f3e5f5; color: #7b1fa2; }
        .status-in-transit { background-color: #e8f5e8; color: #388e3c; }
        .status-delivered { background-color: #e8f5e8; color: #2e7d32; }

        .department-tag {
            background-color: var(--secondary-color);
            color: var(--text-color);
            padding: 0.25rem 0.5rem;
            border-radius: 8px;
            font-size: 0.75rem;
            margin: 0.125rem;
            border: 1px solid var(--border-color);
        }

        .btn-xs {
            padding: 0.125rem 0.25rem;
            font-size: 0.75rem;
            line-height: 1.2;
        }

        .order-summary {
            background-color: var(--secondary-color);
            border-radius: 12px;
            padding: 1rem;
            border: 1px solid var(--border-color);
        }

        .alert {
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
            }
        }

        @media print {
            .sidebar {
                display: none;
            }
            .btn {
                display: none;
            }
            .no-print {
                display: none;
            }
            .floating-icon {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- フローティングアイコン -->
    <i class="fas fa-bread-slice floating-icon"></i>
    <i class="fas fa-cake floating-icon"></i>
    <i class="fas fa-cookie floating-icon"></i>
    <i class="fas fa-muffin floating-icon"></i>
    <i class="fas fa-croissant floating-icon"></i>
    <i class="fas fa-birthday-cake floating-icon"></i>
    <i class="fas fa-cookie-bite floating-icon"></i>
    <i class="fas fa-cheese floating-icon"></i>
    <i class="fas fa-ice-cream floating-icon"></i>
    <i class="fas fa-candy-cane floating-icon"></i>
    <i class="fas fa-bread-slice floating-icon"></i>
    <i class="fas fa-cake floating-icon"></i>
    <i class="fas fa-cookie floating-icon"></i>
    <i class="fas fa-muffin floating-icon"></i>
    <i class="fas fa-croissant floating-icon"></i>
    <i class="fas fa-birthday-cake floating-icon"></i>
    <i class="fas fa-cookie-bite floating-icon"></i>
    <i class="fas fa-cheese floating-icon"></i>
    <i class="fas fa-ice-cream floating-icon"></i>
    <i class="fas fa-candy-cane floating-icon"></i>
    <i class="fas fa-bread-slice floating-icon"></i>
    <i class="fas fa-cake floating-icon"></i>
    <i class="fas fa-cookie floating-icon"></i>
    <i class="fas fa-muffin floating-icon"></i>
    <i class="fas fa-croissant floating-icon"></i>
    <i class="fas fa-birthday-cake floating-icon"></i>
    <i class="fas fa-cookie-bite floating-icon"></i>
    <i class="fas fa-cheese floating-icon"></i>
    <i class="fas fa-ice-cream floating-icon"></i>
    <i class="fas fa-candy-cane floating-icon"></i>
    <i class="fas fa-bread-slice floating-icon"></i>
    <i class="fas fa-cake floating-icon"></i>
    <i class="fas fa-cookie floating-icon"></i>
    <i class="fas fa-muffin floating-icon"></i>
    <i class="fas fa-croissant floating-icon"></i>
    <i class="fas fa-birthday-cake floating-icon"></i>
    <i class="fas fa-cookie-bite floating-icon"></i>
    <i class="fas fa-cheese floating-icon"></i>
    <i class="fas fa-ice-cream floating-icon"></i>
    <i class="fas fa-candy-cane floating-icon"></i>
    <i class="fas fa-bread-slice floating-icon"></i>
    <i class="fas fa-cake floating-icon"></i>
    <i class="fas fa-cookie floating-icon"></i>
    <i class="fas fa-muffin floating-icon"></i>
    <i class="fas fa-croissant floating-icon"></i>
    <i class="fas fa-birthday-cake floating-icon"></i>
    <i class="fas fa-cookie-bite floating-icon"></i>
    <i class="fas fa-cheese floating-icon"></i>
    <i class="fas fa-ice-cream floating-icon"></i>
    <i class="fas fa-candy-cane floating-icon"></i>

    <div class="container-fluid">
        <div class="row">
            <!-- サイドバー -->
            <div class="col-md-3 col-lg-2 px-0">
                <div class="sidebar p-3" style="position: relative; z-index: 10;">
                    <div class="mb-4 text-center">
                        <img src="{{ asset('images/komi-bakery-logo.svg') }}" alt="コミベーカリー" class="img-fluid mb-2" style="max-width: 180px;">
                        <p class="mb-0 small text-white">注文管理システム</p>
                    </div>

                    @auth
                    <div class="mb-3 p-2" style="background-color: rgba(255, 255, 255, 0.1); border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.2);">
                        <p class="mb-1 small text-warning"><i class="fas fa-user-circle"></i> ログインユーザー</p>
                        <p class="mb-1 small"><i class="fas fa-user"></i> {{ auth()->user()->name }}</p>
                        <p class="mb-0 small">
                            <i class="fas fa-user-tag"></i> 
                            @if(auth()->user()->isAdmin())
                                システム管理者
                            @elseif(auth()->user()->isStore())
                                店舗スタッフ
                            @elseif(auth()->user()->isManufacturing())
                                製造部門
                            @elseif(auth()->user()->isLogistics())
                                物流部門
                            @else
                                一般ユーザー
                            @endif
                        </p>
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
                            <form method="POST" action="{{ secure_url(route('logout', [], false)) }}" class="d-inline">
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
                <div class="p-4" style="position: relative; z-index: 10;">
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
