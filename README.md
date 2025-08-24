# KOMI BAKERY 注文管理システム

コミベーカリーの注文管理システムです。店舗スタッフ、製造部門、物流部門が連携して注文を管理できるWebアプリケーションです。

[![Deploy on Railway](https://railway.app/button.svg)](https://railway.app/template/new?template=https://github.com/mori800630/komi-order-system)

## 機能

### ユーザー管理
- 管理者、店舗スタッフ、製造部門、物流部門の4つのロール
- 製造部門は部門別の注文表示

### 注文管理
- 注文の登録・編集・削除
- 注文ステータス管理（注文受付 → 製造中 → 梱包中 → 輸送中 → 受け渡し済み）
- 部門別製造ステータス管理
- 顧客情報管理

### 商品管理
- 商品の登録・編集・削除
- 部門別商品管理
- 販売ステータス管理（販売前・販売中・販売終了）

### ダッシュボード
- 注文統計の表示
- 最近の注文一覧
- 部門別注文状況

## 技術スタック

- **フレームワーク**: Laravel 12.x
- **データベース**: PostgreSQL (本番) / SQLite (開発)
- **フロントエンド**: Bootstrap 5, Font Awesome
- **言語**: PHP 8.2+, JavaScript
- **デプロイ**: Railway

## Railwayでのデプロイ

### クイックデプロイ
上記の「Deploy on Railway」ボタンをクリックして、ワンクリックでデプロイできます。

### 手動デプロイ

#### 1. Railwayアカウントの準備
1. [Railway](https://railway.app/) にアクセス
2. GitHubアカウントでログイン

#### 2. プロジェクトのデプロイ
1. Railwayダッシュボードで「New Project」をクリック
2. 「Deploy from GitHub repo」を選択
3. リポジトリ名を入力: `mori800630/komi-order-system`
4. デプロイが開始されます

#### 3. 環境変数の設定
Railwayダッシュボードで以下の環境変数を設定：

```
APP_NAME="KOMI BAKERY"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app-name.railway.app

DB_CONNECTION=postgresql
DB_HOST=your-postgres-host
DB_PORT=5432
DB_DATABASE=railway
DB_USERNAME=postgres
DB_PASSWORD=your-postgres-password

LOG_CHANNEL=stack
LOG_LEVEL=debug

CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

#### 4. データベースの設定
1. RailwayでPostgreSQLサービスを追加
2. 環境変数でデータベース接続情報を設定
3. デプロイ後にマイグレーションとシーダーが自動実行されます

#### 5. デモアカウント
デプロイ後、以下のアカウントでログインできます：

- **管理者**: admin@komi-bakery.com / password
- **店舗スタッフ**: sato.misaki@komi-bakery.com / password
- **製造担当**: yamada.ichiro@komi-bakery.com / password
- **物流担当**: ishikawa.kuro@komi-bakery.com / password

**全30人のテストユーザーが利用可能です。**

## ローカル開発環境

### 必要な環境
- PHP 8.2+
- Composer
- SQLite

### セットアップ手順

1. リポジトリをクローン
```bash
git clone https://github.com/mori800630/komi-order-system.git
cd komi-order-system
```

2. 依存関係をインストール
```bash
composer install
```

3. 環境設定
```bash
cp .env.example .env
php artisan key:generate
```

4. データベースの準備
```bash
touch database/database.sqlite
php artisan migrate
php artisan db:seed
```

5. 開発サーバーを起動
```bash
php artisan serve
```

6. ブラウザでアクセス
```
http://localhost:8000
```

## プロジェクト構造

```
komi-order-system/
├── app/
│   ├── Http/Controllers/    # コントローラー
│   ├── Models/             # Eloquentモデル
│   └── Http/Middleware/    # ミドルウェア
├── database/
│   ├── migrations/         # データベースマイグレーション
│   └── seeders/           # シーダー
├── resources/
│   └── views/             # Bladeテンプレート
├── routes/                # ルート定義
└── public/               # 静的ファイル
```

## ライセンス

MIT License

## 作者

KOMI BAKERY 開発チーム
