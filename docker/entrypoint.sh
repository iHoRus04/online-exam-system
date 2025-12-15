#!/usr/bin/env bash
set -e

echo "==> Entrypoint start"

# Number of tries and sleep interval for DB wait
TRIES=${DB_WAIT_TRIES:-30}
SLEEP=${DB_WAIT_SLEEP:-1}

wait_for_db() {
  for i in $(seq 1 $TRIES); do
    php -r '
      $conn = getenv("DB_CONNECTION") ?: "sqlite";
      if ($conn === "sqlite") {
          exit(0);
      }
      $host = getenv("DB_HOST") ?: "127.0.0.1";
      $port = getenv("DB_PORT") ?: ($conn === "pgsql" ? 5432 : 3306);
      $db = getenv("DB_DATABASE") ?: "";
      $user = getenv("DB_USERNAME") ?: "";
      $pass = getenv("DB_PASSWORD") ?: "";
      try {
          if ($conn === "pgsql") {
              $dsn = "pgsql:host={$host};port={$port};dbname={$db}";
          } else {
              $dsn = "mysql:host={$host};port={$port};dbname={$db}";
          }
          $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_TIMEOUT => 3]);
          exit(0);
      } catch (Exception $e) {
          exit(1);
      }
    '
    if [ $? -eq 0 ]; then
      echo "==> Database is reachable."
      return 0
    fi
    echo "Waiting for DB... ($i/$TRIES)"
    sleep $SLEEP
  done

  echo "==> Timeout waiting for DB. Continuing (migrations may fail)."
  return 1
}

# Wait for DB unless using sqlite
if [ "${DB_CONNECTION:-sqlite}" != "sqlite" ]; then
  wait_for_db
fi

# Ensure Laravel reads current env
echo "==> Clearing config cache (safe)"
php artisan config:clear || true

# Ensure correct permissions for storage/cache
echo "==> Setting permissions for storage and bootstrap/cache"
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache || true

# Run migrations (non-interactive)
echo "==> Running migrations"
if php artisan migrate --force; then
  echo "==> Migrations completed"
else
  echo "==> Migrations failed (continuing). Check logs."
  # If you'd rather fail the container when migrations fail, uncomment:
  # exit 1
fi

# Ensure storage symlink (no-op if exists)
echo "==> Ensuring storage:link"
php artisan storage:link || true

# Cache config/routes only in production for safety
if [ "${APP_ENV:-production}" = "production" ]; then
  echo "==> Caching config and routes (production)"
  php artisan config:cache || true
  php artisan route:cache || true
else
  echo "==> Skipping config/route cache (APP_ENV=${APP_ENV:-local})"
fi

echo "==> Starting supervisord"
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf