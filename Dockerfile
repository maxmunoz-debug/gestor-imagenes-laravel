# Usamos una imagen moderna optimizada para Laravel con PHP 8.4
FROM serversideup/php:8.4-fpm-nginx

# Cambiamos temporalmente a root para copiar los archivos con los permisos correctos
USER root

# Copiamos todos los archivos del proyecto asignándole el dueño del servidor web (www-data)
COPY --chown=www-data:www-data . .

# Regresamos al usuario seguro del servidor
USER www-data

# Instalamos las dependencias de Composer durante la compilación en la nube
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader