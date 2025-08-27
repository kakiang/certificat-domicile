#!/usr/bin/env bash
set -euxo pipefail

# Install PHP dependencies
composer install --no-dev --prefer-dist --optimize-autoloader --working-dir=/var/www/html

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

# Laravel setup
php artisan storage:link || true

# Optimize + migrate
php artisan optimize

echo "Running migrations..."
php artisan migrate --force || true