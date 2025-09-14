#!/bin/sh
set -e

if [ ! -f /var/www/thewall.sqlite ]; then
    touch /var/www/thewall.sqlite
    chown www-data:www-data /var/www/thewall.sqlite
    echo "SQLite database created: /var/www/thewall.sqlite"
fi
composer install

php "/var/www/artisan" migrate
php "/var/www/artisan" db:seed --class=DevSeeder
php "/var/www/artisan" storage:link
php "/var/www/artisan" config:clear
php "/var/www/artisan" cache:clear
php "/var/www/artisan" route:clear
php "/var/www/artisan" optimize:clean
php "/var/www/artisan" optimize

exec php-fpm
