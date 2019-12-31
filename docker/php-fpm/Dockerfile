FROM php:7.2-fpm

RUN apt-get update && apt-get install -y zlibc zlib1g zlib1g-dev libzip-dev libzip4 \
    && pecl install xdebug-2.7.1 \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-configure pdo_mysql \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install zip \
    && docker-php-ext-install opcache

ADD php.ini /usr/local/etc/php/php.ini
ADD opcache.ini /usr/local/etc/php/conf.d/opcache.ini

WORKDIR /app