#!/bin/sh

cd /var/www
composer install --optimize-autoloader --no-dev
php artisan migrate:fresh --seed
php artisan cache:clear
php artisan route:cache
php artisan storage:link
