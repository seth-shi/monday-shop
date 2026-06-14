FROM node:22-alpine AS frontend
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY vite.config.js ./
COPY resources ./resources
RUN npm run build

FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-progress --prefer-dist --ignore-platform-reqs --no-scripts

FROM php:8.4-fpm-alpine AS app

RUN apk add --no-cache \
        bash curl icu-data-full icu-dev libjpeg-turbo-dev libpng-dev libzip-dev oniguruma-dev sqlite-dev \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" bcmath exif gd intl mbstring opcache pcntl pdo_sqlite zip

WORKDIR /var/www/html
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=frontend /app/public/build ./public/build
COPY docker/php.ini /usr/local/etc/php/conf.d/99-monday-shop.ini
COPY docker/entrypoint.sh /usr/local/bin/monday-shop-entrypoint

RUN chmod +x /usr/local/bin/monday-shop-entrypoint \
    && mkdir -p storage/framework/{cache,sessions,testing,views} storage/logs bootstrap/cache \
    && rm -f bootstrap/cache/*.php \
    && php artisan package:discover --ansi \
    && chown -R www-data:www-data storage bootstrap/cache

ENTRYPOINT ["monday-shop-entrypoint"]
CMD ["php-fpm", "-F"]
