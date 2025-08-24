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
            --primary-color: #8B4513;
            --secondary-color: #D2B48C;
            --accent-color: #FF6B35;
            --success-color: #28a745;
            --light-bg: #F5F5DC;
            --glass-bg: rgba(255, 255, 255, 0.25);
            --glass-border: rgba(255, 255, 255, 0.18);
        }

        body {
            background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 25%, #FF5722 50%, #E64A19 75%, #D84315 100%);
            min-height: 100vh;
            font-family: 'Hiragino Kaku Gothic ProN', 'Yu Gothic', sans-serif;
            position: relative;
            overflow-x: hidden;
        }

        /* 背景装飾 */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
            pointer-events: none;
            z-index: 1;
        }

        /* フローティングアイコン */
        .floating-icon {
            position: fixed;
            color: rgba(255, 255, 255, 0.1);
            font-size: 2rem;
            animation: float 6s ease-in-out infinite;
            z-index: 1;
        }

        .floating-icon:nth-child(1) { top: 10%; left: 10%; animation-delay: 0s; }
        .floating-icon:nth-child(2) { top: 20%; right: 15%; animation-delay: 1s; }
        .floating-icon:nth-child(3) { bottom: 30%; left: 5%; animation-delay: 2s; }
        .floating-icon:nth-child(4) { bottom: 20%; right: 10%; animation-delay: 3s; }
        .floating-icon:nth-child(5) { top: 50%; left: 5%; animation-delay: 4s; }
        .floating-icon:nth-child(6) { top: 60%; right: 5%; animation-delay: 5s; }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
        }

        .login-container {
            position: relative;
            z-index: 10;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .login-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 3rem 2rem;
            width: 100%;
            max-width: 500px;
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #FF8C42, #FF6B35, #FF5722, #E64A19);
        }

        .logo-section {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .logo-container {
            width: 150px;
            height: 80px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 40px;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .logo-container:hover {
            transform: scale(1.05);
        }

        .logo-container img {
            max-width: 120px;
            max-height: 60px;
        }

        .brand-title {
            color: white;
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .brand-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
            margin-bottom: 0;
        }

        /* フォームスタイル */
        .form-floating {
            margin-bottom: 1.5rem;
        }

        .form-floating .form-control {
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 1rem;
            padding: 1rem 1rem 1rem 3rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-floating .form-control:focus {
            background: rgba(255, 255, 255, 0.95);
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25);
            transform: translateY(-2px);
        }

        .form-floating .form-control:focus + label {
            color: var(--accent-color);
        }

        .form-floating label {
            padding-left: 3rem;
            color: #666;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            z-index: 10;
            transition: color 0.3s ease;
        }

        .form-floating .form-control:focus ~ .input-icon {
            color: var(--accent-color);
        }

        .form-check {
            margin-bottom: 2rem;
        }

        .form-check-input {
            background-color: rgba(255, 255, 255, 0.9);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .form-check-input:checked {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .form-check-label {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
        }

        /* ログインボタン */
        .btn-login {
            background: linear-gradient(135deg, #FF8C42 0%, #FF6B35 50%, #FF5722 100%);
            border: none;
            border-radius: 1rem;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: bold;
            color: white;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            width: 100%;
            margin-bottom: 2rem;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 107, 53, 0.4);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        /* デモアカウントセクション */
        .demo-section {
            margin-top: 2rem;
        }

        .demo-title {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 1.5rem;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        .demo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .demo-card {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 1rem;
            padding: 1rem;
            text-align: center;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .demo-card:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
        }

        .demo-card.admin { border-left: 4px solid #dc3545; }
        .demo-card.store { border-left: 4px solid #28a745; }
        .demo-card.manufacturing { border-left: 4px solid #ffc107; }
        .demo-card.logistics { border-left: 4px solid #17a2b8; }

        .demo-icon {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .demo-card.admin .demo-icon { color: #dc3545; }
        .demo-card.store .demo-icon { color: #28a745; }
        .demo-card.manufacturing .demo-icon { color: #ffc107; }
        .demo-card.logistics .demo-icon { color: #17a2b8; }

        .demo-role {
            color: white;
            font-weight: bold;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .demo-email {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.8rem;
            margin-bottom: 0.25rem;
            word-break: break-all;
        }

        .demo-password {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.8rem;
            font-family: monospace;
        }

        /* エラーメッセージ */
        .alert {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #fff;
            border-radius: 1rem;
            backdrop-filter: blur(10px);
        }

        /* レスポンシブ対応 */
        @media (max-width: 768px) {
            .login-card {
                padding: 2rem 1.5rem;
                margin: 1rem;
            }

            .brand-title {
                font-size: 1.5rem;
            }

            .demo-grid {
                grid-template-columns: 1fr;
            }

            .floating-icon {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 1.5rem 1rem;
            }

            .logo-container {
                width: 120px;
                height: 60px;
            }

            .logo-container img {
                max-width: 90px;
                max-height: 45px;
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

    <div class="login-container">
        <div class="login-card">
            <!-- ロゴセクション -->
            <div class="logo-section">
                <div class="logo-container">
                    <img src="{{ asset('images/komi-bakery-logo.svg') }}" alt="コミベーカリー">
                </div>
                <h1 class="brand-title">コミベーカリー</h1>
                <p class="brand-subtitle">注文管理システム</p>
            </div>

            <!-- エラーメッセージ -->
            @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                </div>
            @endif

            <!-- ログインフォーム -->
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-floating">
                    <i class="fas fa-envelope input-icon"></i>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}" 
                           placeholder="メールアドレス" required autofocus>
                    <label for="email">メールアドレス</label>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                           id="password" name="password" placeholder="パスワード" required>
                    <label for="password">パスワード</label>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">
                        <i class="fas fa-clock me-1"></i>ログイン状態を保持
                    </label>
                </div>

                <button type="submit" class="btn btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>ログイン
                </button>
            </form>

            <!-- デモアカウントセクション -->
            <div class="demo-section">
                <h3 class="demo-title">
                    <i class="fas fa-users me-2"></i>デモ用アカウント
                </h3>
                <div class="demo-grid">
                    <div class="demo-card admin">
                        <div class="demo-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="demo-role">管理者</div>
                        <div class="demo-email">tanaka.masayoshi@komi-bakery.com</div>
                        <div class="demo-password">password123</div>
                    </div>
                    
                    <div class="demo-card store">
                        <div class="demo-icon">
                            <i class="fas fa-store"></i>
                        </div>
                        <div class="demo-role">店舗担当</div>
                        <div class="demo-email">sato.misaki@komi-bakery.com</div>
                        <div class="demo-password">password123</div>
                    </div>
                    
                    <div class="demo-card manufacturing">
                        <div class="demo-icon">
                            <i class="fas fa-industry"></i>
                        </div>
                        <div class="demo-role">洋菓子製造担当</div>
                        <div class="demo-email">yamada.ichiro@komi-bakery.com</div>
                        <div class="demo-password">password123</div>
                    </div>
                    
                    <div class="demo-card logistics">
                        <div class="demo-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div class="demo-role">物流担当</div>
                        <div class="demo-email">ogawa.juichiro@komi-bakery.com</div>
                        <div class="demo-password">password123</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
