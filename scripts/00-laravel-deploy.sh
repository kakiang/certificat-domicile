#!/usr/bin/env bash
set -euxo pipefail

# Always run from Laravel root
cd /var/www/html

# Install PHP deps (no prestissimo needed, Composer 2 is already fast)
composer install --no-dev --prefer-dist --optimize-autoloader

# Install PHP dependencies
# composer install --no-dev --prefer-dist --optimize-autoloader --working-dir=/var/www/html

# echo "Caching config..."
# php artisan config:cache

# echo "Caching routes..."
# php artisan route:cache

# Laravel setup
php artisan storage:link || true

# Optimize
php artisan optimize:clear
php artisan optimize

# Ensure session table exists
php artisan session:table || true
echo "Running migrations..."
php artisan migrate --force || true