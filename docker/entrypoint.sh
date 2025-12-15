#!/bin/bash
set -e

# Run migrations
php artisan migrate --force || true

# Run storage link
php artisan storage:link || true

# Cache config and routes
php artisan config:cache || true
php artisan route:cache || true

# Start supervisor
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
