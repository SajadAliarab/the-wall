#!/bin/sh
set -e


if [ ! -f /var/www/thewall.sqlite ]; then
    touch /var/www/thewall.sqlite
    chown www-data:www-data /var/www/thewall.sqlite
    echo "SQLite database created: /var/www/thewall.sqlite"
fi

if [ ! -d /var/www/vendor ]; then
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi


php /var/www/artisan migrate --force || echo "Migration failed (maybe already migrated)"
php /var/www/artisan db:seed --class=DevSeeder --force || echo "Seeding failed (maybe already seeded)"


php /var/www/artisan storage:link || true
php /var/www/artisan config:clear || true
php /var/www/artisan cache:clear || true
php /var/www/artisan route:clear || true



exec php-fpm
