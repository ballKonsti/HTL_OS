#!/bin/sh
set -e
[ -f .env ] || cp .env.example .env
[ -d vendor ] || composer install --no-interaction
grep -q '^APP_KEY=base64' .env || php artisan key:generate
php artisan migrate --force
[ -d node_modules ] || (npm install && npm run build)
chown -R www-data:www-data storage bootstrap/cache
exec "$@"
