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
        }

        body {
            background: linear-gradient(135deg, #F5E6D3 0%, #E8D5B7 100%);
            min-height: 100vh;
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', sans-serif;
            margin: 0;
            padding: 0;
            position: relative;
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

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            z-index: 2;
        }

        .login-card {
            background: var(--light-bg);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 3rem 2.5rem;
            width: 100%;
            max-width: 480px;
            position: relative;
        }

        /* ロゴセクション */
        .logo-section {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .logo-container {
            margin-bottom: 1rem;
        }

        .logo-container img {
            width: 80px;
            height: auto;
        }

        .brand-title {
            font-family: 'Georgia', serif;
            font-size: 2.2rem;
            font-weight: 600;
            color: var(--text-color);
            margin: 0 0 0.5rem 0;
            letter-spacing: 1px;
        }

        .brand-subtitle {
            font-size: 0.9rem;
            color: var(--text-color);
            opacity: 0.7;
            margin: 0;
            font-weight: 300;
        }

        /* エラーメッセージ */
        .alert {
            border: none;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        /* フォーム要素 */
        .form-floating {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-control {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1rem 1rem 1rem 3.5rem;
            font-size: 1rem;
            background-color: white;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(212, 165, 116, 0.25);
            outline: none;
        }

        .form-floating label {
            color: var(--text-color);
            opacity: 0.8;
            font-weight: 400;
            padding-left: 3.5rem;
        }

        .input-icon {
            position: absolute;
            left: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-color);
            opacity: 0.6;
            z-index: 3;
        }

        /* チェックボックス */
        .form-check {
            margin-bottom: 2rem;
        }

        .form-check-input {
            border-color: var(--border-color);
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-label {
            color: var(--text-color);
            font-size: 0.9rem;
            opacity: 0.8;
        }

        /* ログインボタン */
        .btn-login {
            background-color: var(--primary-color);
            border: none;
            border-radius: 8px;
            padding: 1rem 2rem;
            font-size: 1rem;
            font-weight: 500;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
            margin-bottom: 2.5rem;
        }

        .btn-login:hover {
            background-color: var(--accent-color);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(212, 165, 116, 0.3);
        }

        /* デモアカウントセクション */
        .demo-section {
            border-top: 1px solid var(--border-color);
            padding-top: 2rem;
        }

        .demo-title {
            font-size: 1rem;
            color: var(--text-color);
            margin-bottom: 1.5rem;
            text-align: center;
            font-weight: 500;
        }

        .demo-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .demo-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .demo-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .demo-icon {
            margin-bottom: 0.5rem;
        }

        .demo-icon i {
            font-size: 1.2rem;
            color: var(--primary-color);
        }

        .demo-role {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.3rem;
        }

        .demo-email {
            font-size: 0.7rem;
            color: var(--text-color);
            opacity: 0.7;
            margin-bottom: 0.2rem;
            word-break: break-all;
        }

        .demo-password {
            font-size: 0.7rem;
            color: var(--text-color);
            opacity: 0.5;
            font-family: 'Courier New', monospace;
        }

        /* レスポンシブ対応 */
        @media (max-width: 576px) {
            .login-container {
                padding: 1rem;
            }
            
            .login-card {
                padding: 2rem 1.5rem;
            }
            
            .demo-grid {
                grid-template-columns: 1fr;
            }
            
            .brand-title {
                font-size: 1.8rem;
            }
        }

        /* 印刷時の非表示 */
        @media print {
            .demo-section {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <!-- ロゴセクション -->
            <div class="logo-section">
                <div class="logo-container">
                    <img src="{{ asset('images/komi-bakery-logo.svg') }}" alt="KOMI BAKERY">
                </div>
                <h1 class="brand-title">コミベーカリー様</h1>
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
                    <div class="demo-card">
                        <div class="demo-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="demo-role">管理者</div>
                        <div class="demo-email">tanaka.masayoshi@komi-bakery.com</div>
                        <div class="demo-password">password123</div>
                    </div>
                    
                    <div class="demo-card">
                        <div class="demo-icon">
                            <i class="fas fa-store"></i>
                        </div>
                        <div class="demo-role">店舗担当</div>
                        <div class="demo-email">sato.misaki@komi-bakery.com</div>
                        <div class="demo-password">password123</div>
                    </div>
                    
                    <div class="demo-card">
                        <div class="demo-icon">
                            <i class="fas fa-industry"></i>
                        </div>
                        <div class="demo-role">洋菓子製造担当</div>
                        <div class="demo-email">yamada.ichiro@komi-bakery.com</div>
                        <div class="demo-password">password123</div>
                    </div>
                    
                    <div class="demo-card">
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

