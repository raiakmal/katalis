#!/bin/sh
set -e

echo "=== Preparing Laravel directories ==="

mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/framework/cache
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/bootstrap/cache

chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache

chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

echo "=== Clearing Laravel cache ==="

php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true

echo "=== Starting PHP-FPM ==="

php-fpm -D

echo "=== Starting Nginx ==="

exec nginx -g "daemon off;"