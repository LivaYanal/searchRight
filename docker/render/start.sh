#!/bin/sh
# Wordt uitgevoerd elke keer dat de app op Render start.
set -e
cd /var/www/html

# Render geeft de poort door via $PORT (standaard 10000)
PORT="${PORT:-10000}"
sed -i "s/^Listen 80$/Listen ${PORT}/" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Database bijwerken + demodata (slaat over als die er al is)
php artisan migrate --force
php artisan db:seed --class=TechnologySeeder --force
php artisan db:seed --class=DemoSeeder --force

# Sneller maken voor productie
php artisan config:cache
php artisan route:cache
php artisan view:cache
chown -R www-data:www-data storage bootstrap/cache

exec apache2-foreground
