#!/bin/bash

# Railway deployment script for Laravel application

echo "Starting deployment..."

# Generate application key if not exists
php artisan key:generate --force

# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force

# Run seeders if needed
echo "Running database seeders..."
php artisan db:seed --class=DepartmentSeeder --force
php artisan db:seed --class=OrderStatusSeeder --force
php artisan db:seed --class=OrderStatusTransitionSeeder --force
php artisan db:seed --class=UserSeeder --force
php artisan db:seed --class=CustomerSeeder --force
php artisan db:seed --class=ProductSeeder --force
php artisan db:seed --class=SampleOrderSeeder --force
php artisan db:seed --class=AdditionalDeliveredOrderSeeder --force

# Optimize for production
php artisan optimize

echo "Deployment completed successfully!"
