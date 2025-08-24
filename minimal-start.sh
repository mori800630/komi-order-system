#!/bin/bash

echo "=== Minimal Start Script ==="
echo "Current directory: $(pwd)"
echo "PORT: $PORT"

# 基本的なPHPサーバーを起動（Laravelを使わない）
echo "Starting minimal PHP server..."
php -S 0.0.0.0:$PORT -t public/
