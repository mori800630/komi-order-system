#!/bin/bash

# エラー時に停止
set -e

echo "Starting application initialization..."

# 環境変数を設定
export APP_ENV=${APP_ENV:-production}
export APP_DEBUG=${APP_DEBUG:-false}
export APP_KEY=${APP_KEY:-base64:$(openssl rand -base64 32)}
export DB_CONNECTION=${DB_CONNECTION:-sqlite}
export DB_DATABASE=${DB_DATABASE:-/app/database/database.sqlite}
export LOG_CHANNEL=${LOG_CHANNEL:-stack}
export SESSION_DRIVER=${SESSION_DRIVER:-file}
export CACHE_DRIVER=${CACHE_DRIVER:-file}
export QUEUE_CONNECTION=${QUEUE_CONNECTION:-sync}
export FORCE_HTTPS=${FORCE_HTTPS:-true}
export APP_URL=${APP_URL:-https://web-production-aec3a.up.railway.app}
export SESSION_LIFETIME=${SESSION_LIFETIME:-480}
export SESSION_SECURE_COOKIE=${SESSION_SECURE_COOKIE:-true}
export SESSION_SAME_SITE=${SESSION_SAME_SITE:-none}

echo "Environment variables set:"
echo "APP_ENV: $APP_ENV"
echo "APP_KEY: $APP_KEY"
echo "DB_CONNECTION: $DB_CONNECTION"
echo "DB_DATABASE: $DB_DATABASE"

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
php artisan migrate --force || {
    echo "Migration failed, but continuing..."
}

echo "Running database seeders..."
php artisan db:seed --force || {
    echo "Seeding failed, but continuing..."
}

echo "Application initialization completed successfully!"

# アプリケーションを起動
echo "Starting Laravel application..."
php artisan serve --host=0.0.0.0 --port=$PORT
