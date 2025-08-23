# Komi BAKERY 注文管理システム

こみベーカリー様の注文管理システムです。Laravel PHPで構築されており、注文の登録から製造、梱包、配送までの一連のワークフローを管理できます。

## 機能概要

### 主要機能
- **注文管理**: 注文の登録、編集、ステータス管理
- **顧客管理**: 顧客情報の登録・管理
- **商品管理**: 商品マスターの管理
- **部門別管理**: 製造部門ごとの注文表示
- **ステータス管理**: 注文受付 → 製造中 → 梱包中 → 輸送中 → 受け渡し済み

### ユーザー権限
- **システム管理者 (admin)**: 全機能にアクセス可能
- **店舗担当 (store)**: 注文管理、顧客管理
- **製造担当 (manufacturing)**: 部門別注文表示
- **運送担当 (logistics)**: 配送管理

## 技術仕様

- **フレームワーク**: Laravel 12.x
- **データベース**: SQLite (開発環境) / PostgreSQL (本番環境)
- **フロントエンド**: Bootstrap 5 + Font Awesome
- **言語**: PHP 8.2+

## インストール・セットアップ

### 1. リポジトリのクローン
```bash
git clone <repository-url>
cd komi-order-system
```

### 2. 依存関係のインストール
```bash
composer install
```

### 3. 環境設定
```bash
cp .env.example .env
php artisan key:generate
```

### 4. データベース設定
`.env`ファイルでデータベース接続を設定：
```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

### 5. データベースのマイグレーションとシーダー実行
```bash
php artisan migrate:fresh --seed
```

### 6. 開発サーバーの起動
```bash
php artisan serve
```

## デモ用アカウント

システムには以下のデモ用アカウントが用意されています：

### 管理者アカウント
- **メール**: admin@komi-bakery.com
- **パスワード**: password

### 店舗担当アカウント
- **メール**: store@komi-bakery.com
- **パスワード**: password

### 製造部門アカウント
- **洋菓子製造**: western@komi-bakery.com
- **サンドイッチ製造**: sandwich@komi-bakery.com
- **パン製造**: bread@komi-bakery.com
- **チーズケーキ製造(本店)**: cheesecake_main@komi-bakery.com
- **チーズケーキ製造(南国店)**: cheesecake_nangoku@komi-bakery.com
- **パスワード**: password

### 運送担当アカウント
- **メール**: logistics@komi-bakery.com
- **パスワード**: password

## システムの使い方

### 1. 注文登録
1. ログイン後、「新規注文登録」ボタンをクリック
2. 顧客情報を選択（または新規作成）
3. 商品を選択し、数量を指定
4. 受け取り方法を選択
5. 必要に応じて配送情報を入力
6. 注文を登録

### 2. ステータス管理
1. 注文詳細画面で「ステータス変更」セクションを使用
2. 新しいステータスを選択（一方通行）
3. 変更理由・備考を入力
4. ステータスを更新

### 3. 部門別表示
- 製造担当者は自分の部門の注文のみ表示
- 管理者は全部門の注文を表示可能

## データベース構造

### 主要テーブル
- **users**: ユーザー情報
- **departments**: 製造部門
- **customers**: 顧客情報
- **products**: 商品マスター
- **orders**: 注文情報
- **order_items**: 注文商品詳細
- **order_statuses**: 注文ステータス
- **order_status_histories**: ステータス変更履歴

## 開発・カスタマイズ

### 新しい機能の追加
1. マイグレーションファイルの作成
2. モデルの作成・編集
3. コントローラーの実装
4. ビューファイルの作成
5. ルートの設定

### スタイルのカスタマイズ
- `resources/views/layouts/app.blade.php`のCSSを編集
- Bootstrap 5のカスタム変数を使用

## 注意事項

- ステータスは一方通行で変更されます
- 梱包中ステータスに変更するには顧客情報（住所・電話番号）が必要です
- 製造担当者は自分の部門の注文のみ表示・操作可能です

## ライセンス

このプロジェクトはこみベーカリー様専用のシステムです。

## サポート

システムに関する質問や問題がございましたら、開発チームまでお問い合わせください。
