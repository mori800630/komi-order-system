#!/bin/bash

echo "=== Step-by-Step Start Script ==="

# ステップ1: 環境変数を設定
echo "Step 1: Setting up environment..."
source ./bootstrap-env.sh

# ステップ2: 基本的なPHPサーバーでテスト
echo "Step 2: Testing basic PHP server..."
echo "Starting minimal PHP server on port $PORT"
php -S 0.0.0.0:$PORT -t public/
