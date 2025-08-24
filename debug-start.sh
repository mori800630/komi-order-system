#!/bin/bash

echo "=== Debug Start Script ==="
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
echo "=== Laravel Version ==="
php artisan --version

echo ""
echo "=== Database Check ==="
if [ -f "/app/database/database.sqlite" ]; then
    echo "SQLite database file exists"
    ls -la /app/database/
else
    echo "SQLite database file does not exist"
fi

echo ""
echo "=== Starting Simple PHP Server ==="
php -S 0.0.0.0:$PORT -t public/
