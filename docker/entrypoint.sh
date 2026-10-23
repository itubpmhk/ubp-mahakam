#!/bin/sh
# Runs every time the container starts.
set -e
cd /var/www/html

# storage lives in a Docker volume (uploads survive rebuilds); make sure the folders exist
mkdir -p storage/app/public storage/framework/cache/data storage/framework/sessions \
         storage/framework/views storage/logs bootstrap/cache

if [ ! -f .env ]; then
  echo "ERROR: file .env tidak ditemukan. Buat .env di folder project server (lihat .env.server.example)."
  exit 1
fi

# /storage -> storage/app/public (uploaded pictures)
[ -L public/storage ] || php artisan storage:link --no-interaction || true

# apply new database tables (waits until MySQL is ready)
if [ "${RUN_MIGRATIONS:-true}" = "true" ]; then
  i=0
  until php artisan migrate --force --no-interaction; do
    i=$((i + 1))
    if [ "$i" -ge 30 ]; then echo "Database belum siap, berhenti."; exit 1; fi
    echo "Menunggu database... ($i)"
    sleep 3
  done
fi

# speed: cache config, routes and views (refreshed on every start)
php artisan config:cache
php artisan route:cache
php artisan view:cache

# files created above by root must stay writable for Apache
chown -R www-data:www-data storage bootstrap/cache

exec "$@"
