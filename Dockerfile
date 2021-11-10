FROM phpswoole/swoole:php7.4-alpine

# 修改中国镜像源
RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g' /etc/apk/repositories && cat /etc/apk/repositories

# 快速安装 PHP 扩展
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions pcntl redis pdo_mysql gd

WORKDIR /var/www
COPY . .
RUN chmod -R 0777 storage && chmod -R 0777 bootstrap/cache && composer install

RUN php artisan migrate && php artisan storage:link && php artisan moon:copy

RUN php artisan laravels publish --no-interaction


CMD ["php", "bin/laravels", "start", "--env=product"]