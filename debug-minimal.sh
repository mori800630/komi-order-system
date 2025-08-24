#!/bin/bash

echo "=== Debug Minimal Script ==="
echo "Current directory: $(pwd)"
echo "Files in current directory:"
ls -la

echo ""
echo "=== Environment Variables ==="
echo "PORT: $PORT"
echo "APP_ENV: $APP_ENV"
echo "DB_CONNECTION: $DB_CONNECTION"

echo ""
echo "=== PHP Version ==="
php --version

echo ""
echo "=== PHP Extensions ==="
php -m

echo ""
echo "=== Public Directory Contents ==="
ls -la public/

echo ""
echo "=== Starting Simple PHP Server ==="
echo "Port: $PORT"
echo "Document Root: public/"
php -S 0.0.0.0:$PORT -t public/
