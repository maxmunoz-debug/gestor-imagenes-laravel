#!/usr/bin/env bash

echo "Instalando dependencias de Composer en producción..."
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --working-dir=/var/www/html

echo "Optimizando la configuración de Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Ejecutando las migraciones..."
php artisan migrate --force