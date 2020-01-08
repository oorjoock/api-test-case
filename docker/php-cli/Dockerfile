FROM php:7.2-cli

RUN rm -rf /tmp/pear

RUN apt update && apt install -y zip zlibc zlib1g zlib1g-dev \
    && pecl install xdebug-2.7.1 \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-configure pdo_mysql \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install opcache

ADD php.ini /usr/local/etc/php/php.ini
ADD opcache.ini /usr/local/etc/php/conf.d/opcache.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

ENV COMPOSER_ALLOW_SUPERUSER 1

WORKDIR /app