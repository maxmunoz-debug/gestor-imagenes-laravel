#!/usr/bin/env bash

echo "Optimizando la configuración de Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Ejecutando las migraciones..."
php artisan migrate --force