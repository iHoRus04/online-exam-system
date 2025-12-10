#!/usr/bin/env bash
set -e
# Run migrations and prepare the app, then start the PHP built-in server
php artisan migrate --force || true
php artisan storage:link || true
php artisan config:cache || true
php artisan route:cache || true
exec php -S 0.0.0.0:${PORT:-10000} -t public
