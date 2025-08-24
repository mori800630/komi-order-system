#!/bin/bash

echo "=== Simple Start Script ==="
echo "Current directory: $(pwd)"
echo "PORT: $PORT"

# 基本的なPHPサーバーを起動
echo "Starting basic PHP server..."
php -S 0.0.0.0:$PORT -t public/
