FROM phpswoole/swoole:php7.4

# 修改中国镜像源
RUN sed -i "s@http://deb.debian.org@http://mirrors.aliyun.com@g" /etc/apt/sources.list && rm -Rf /var/lib/apt/lists/* && apt-get update

# 快速安装 PHP 扩展
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions pcntl redis pdo_mysql gd

WORKDIR /var/www
COPY . .
RUN chmod -R 0777 storage && \
    chmod -R 0777 bootstrap/cache && \
    composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/ && \
    composer install --optimize-autoloader --no-dev && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan migrate && \
    php artisan storage:link && \
    php artisan moon:copy && \
    php artisan laravels publish --no-interaction


# this copies pyroscope binary from pyroscope image to your image:
COPY --from=pyroscope/pyroscope:latest /usr/bin/pyroscope /usr/bin/pyroscope

## 建议在 docker run --env 注入环境变量
#ENV PYROSCOPE_SERVER_ADDRESS=
#ENV PYROSCOPE_APPLICATION_NAME=
#ENV PYROSCOPE_AUTH_TOKEN=
## docker run -d --cap-add=sys_ptrace --env PYROSCOPE_SERVER_ADDRESS=xx --env PYROSCOPE_APPLICATION_NAME=xx --env PYROSCOPE_AUTH_TOKEN=xx -p 80:5200 --name monday-shop-service monday-shop

CMD ["pyroscope", "exec", "php", "bin/laravels", "start", "--env=product"]
#CMD ["php", "bin/laravels", "start", "--env=product"]
