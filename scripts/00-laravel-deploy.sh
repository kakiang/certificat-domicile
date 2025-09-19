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

echo "DB Laravel is connected to:"
php artisan tinker --execute="dump(DB::connection()->getDatabaseName());"

php artisan config:clear
# php artisan cache:clear
# php artisan view:clear

# Optimize
# php artisan optimize:clear || true
# php artisan optimize

echo "Running migrations..."
php artisan migrate --force || true

echo "Seeding database..."
php artisan db:seed --force || true

echo "Migration status:"
php artisan migrate:status
echo "Laravel deployment script completed."