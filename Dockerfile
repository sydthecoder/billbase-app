FROM richarvey/nginx-php-fpm:latest

# Copy app source
COPY . .

# Nginx/PHP-FPM image config
ENV SKIP_COMPOSER=1
ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1
ENV COMPOSER_ALLOW_SUPERUSER=1

# Laravel production settings
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr

# Install composer deps at build time (not runtime)
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Laravel needs writable storage/cache dirs
RUN chmod -R 777 storage bootstrap/cache

CMD ["/start.sh"]