FROM php:8.3-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libfreetype6-dev libicu-dev libjpeg62-turbo-dev libonig-dev libpng-dev unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" gd intl mbstring mysqli \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
COPY . .
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress --optimize-autoloader \
    && mkdir -p writable/cache writable/logs writable/session public/uploads/avatars \
    && chown -R www-data:www-data writable public/uploads/avatars

COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf
COPY docker/start.sh /usr/local/bin/tfa3-start
RUN chmod +x /usr/local/bin/tfa3-start

ENV CI_ENVIRONMENT=production
EXPOSE 10000
CMD ["tfa3-start"]
