#!/bin/bash

cd /var/www/crm.buja
git pull origin main
composer install

chown -R www-data:www-data .
