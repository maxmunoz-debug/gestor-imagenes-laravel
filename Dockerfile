FROM richarvey/nginx-php-fpm:3.1.6

COPY . .

# Ejecutar la instalación de Composer durante la compilación en la nube (evita falta de memoria)
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Configuración de la imagen
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Configuración de Laravel
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Permitir ejecutar composer como root en el contenedor
ENV COMPOSER_ALLOW_SUPERUSER 1

CMD ["/start.sh"]