FROM phpswoole/swoole:php7.4-alpine

# 快速安装 PHP 扩展
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions pcntl redis pdo_mysql gd

WORKDIR /var/www
COPY . .
RUN chmod -R 0777 storage && chmod -R 0777 bootstrap/cache && composer install
RUN php artisan laravels publish --no-interaction

CMD ["php", "bin/laravels", "start", "--env=product"]