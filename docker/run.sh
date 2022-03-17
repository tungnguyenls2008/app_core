#!/bin/sh

cd /var/www

# php artisan migrate:fresh --seed
php artisan cache:clear
php artisan route:cache
#test
/usr/bin/supervisord -c /etc/supervisord.conf
chmod -R 777 /var/www/storage
chmod -R 777 /var/www/bootstrap
chmod -R 775 /var/www/public/img/organization_logos
