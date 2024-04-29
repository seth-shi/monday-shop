FROM composer:latest AS vendor

FROM php:8.2-cli-bookworm AS base
ARG TZ=PRC
ENV DEBIAN_FRONTEND=noninteractive \
  TERM=xterm-color \
  OCTANE_SERVER=roadrunner \
  ROOT=/var/www \
  COMPOSER_FUND=0 \
  COMPOSER_MAX_PARALLEL_HTTP=24

WORKDIR ${ROOT}

SHELL ["/bin/bash", "-eou", "pipefail", "-c"]

RUN ln -snf /usr/share/zoneinfo/${TZ} /etc/localtime \
  && echo ${TZ} > /etc/timezone

################################################################################################
## 安装依赖
################################################################################################
ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN apt-get update; \
  apt-get upgrade -yqq; \
  apt-get install -yqq --no-install-recommends --show-progress \
  apt-utils \
  curl \
  wget \
  nano \
  ncdu \
  ca-certificates \
  supervisor \
  libsodium-dev \
  # Install PHP extensions
  && install-php-extensions \
  bz2 \
  pcntl \
  mbstring \
  bcmath \
  sockets \
  pgsql \
  pdo_pgsql \
  opcache \
  exif \
  pdo_mysql \
  zip \
  intl \
  gd \
  redis \
  rdkafka \
  memcached \
  igbinary \
  ldap \
  && apt-get -y autoremove \
  && apt-get clean \
  && docker-php-source delete \
  && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
  && rm /var/log/lastlog /var/log/faillog


################################################################################################
## 复制代码文件和部署文件
################################################################################################
COPY  . .
COPY deployment/supervisord.*.conf /etc/supervisor/conf.d/
COPY deployment/php.ini ${PHP_INI_DIR}/conf.d/99-octane.ini
COPY deployment/start-container /usr/local/bin/start-container

################################################################################################
## 安装依赖
################################################################################################
COPY --from=vendor /usr/bin/composer /usr/bin/composer
RUN touch database/database.sqlite
RUN composer install \
  --no-dev \
  --no-interaction \
  --no-ansi
RUN if composer show | grep spiral/roadrunner-cli >/dev/null; then \
  ./vendor/bin/rr get-binary; else \
  echo "`spiral/roadrunner-cli` package is not installed. Exiting..."; exit 1; \
  fi

################################################################################################
## 权限目录设置
################################################################################################
RUN chmod +x rr /usr/local/bin/start-container
RUN mkdir -p \
  storage/framework/{sessions,views,cache,testing} \
  storage/logs \
  bootstrap/cache && chmod -R a+rw storage

ENTRYPOINT ["start-container"]

HEALTHCHECK --start-period=5s --interval=2s --timeout=5s --retries=8 CMD php artisan octane:status || exit 1
