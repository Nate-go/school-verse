#!/usr/bin/env bash
echo 'Running composer'
composer install --no-dev --working-dir=/var/www/html
 
echo 'Caching config...'
php artisan config:cache
 
echo 'Caching routes...'
php artisan route:cache
 
# echo 'Running migrations...'
#php artisan migrate --force
echo 'Running storage...'
php artisan storage:link

echo 'Running queue...'
php artisan queue:work &

 php -r "echo ini_get('memory_limit').PHP_EOL;" 
 php -r "echo php_ini_loaded_file();" 
 echo 'memory_limit = -1' >>  /usr/local/etc/php/php.ini
 php -r "echo ini_get('memory_limit').PHP_EOL;"