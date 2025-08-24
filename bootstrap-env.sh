#!/bin/bash

echo "=== Bootstrap Environment ==="

# 必要な環境変数を設定
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

echo "APP_ENV: $APP_ENV"
echo "APP_KEY: $APP_KEY"
echo "DB_CONNECTION: $DB_CONNECTION"
echo "DB_DATABASE: $DB_DATABASE"

# データベースディレクトリを作成
mkdir -p /app/database

# データベースファイルを作成
touch /app/database/database.sqlite

echo "Environment setup completed"
