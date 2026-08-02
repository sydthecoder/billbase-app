]FROM dwchiang/nginx-php-fpm:8.3.21-fpm-bookworm-nginx-1.27.4

# Copy your Laravel app in
COPY . /var/www/html

# Install PHP extensions Laravel needs
RUN docker-php-ext-install pdo_mysql bcmath opcache

WORKDIR /var/www/html

# Install composer + deps
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev --optimize-autoloader --no-interaction \
    && chmod -R 775 storage bootstrap/cache