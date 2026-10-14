#!/bin/sh
# Wordt uitgevoerd elke keer dat de app-container start.
set -e

cd /var/www/html

# 1. PHP-packages installeren als ze er nog niet zijn
if [ ! -f vendor/autoload.php ]; then
    echo "[searchRight] composer install..."
    composer install --no-interaction --prefer-dist
fi

# 2. .env aanmaken als die nog niet bestaat
if [ ! -f .env ]; then
    echo "[searchRight] .env aanmaken vanuit .env.example"
    cp .env.example .env
fi

# 3. Applicatiesleutel genereren als die nog leeg is
if ! grep -q '^APP_KEY=base64' .env; then
    php artisan key:generate --force
fi

# 4. Database-tabellen bijwerken
php artisan migrate --force

# 5. Schrijfrechten voor logs en cache
chmod -R ug+rwX storage bootstrap/cache 2>/dev/null || true

exec "$@"
