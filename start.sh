#!/bin/bash

# エラー時に停止
set -e

echo "Starting application initialization..."

# データベースディレクトリを作成
echo "Creating database directory..."
mkdir -p /app/database

# データベースファイルの存在確認
if [ ! -f "/app/database/database.sqlite" ]; then
    echo "Creating SQLite database file..."
    touch /app/database/database.sqlite
fi

# データベースを初期化
echo "Running database migrations..."
php artisan migrate --force

echo "Running database seeders..."
php artisan db:seed --force

echo "Application initialization completed successfully!"

# アプリケーションを起動
echo "Starting Laravel application..."
php artisan serve --host=0.0.0.0 --port=$PORT
