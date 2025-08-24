#!/bin/bash

# データベースディレクトリを作成
mkdir -p /var/www/database

# データベースを初期化
php artisan migrate --force
php artisan db:seed --force

# アプリケーションを起動
php artisan serve --host=0.0.0.0 --port=$PORT
