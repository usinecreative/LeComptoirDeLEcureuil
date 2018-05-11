FROM php:7.2-fpm

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN apt-get update
RUN apt-get install -y git \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        zlib1g-dev \
        libicu-dev \
        g++

RUN pecl install mcrypt-1.0.1
RUN docker-php-ext-enable mcrypt

RUN docker-php-ext-install -j$(nproc) iconv

RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install -j$(nproc) zip
RUN docker-php-ext-install -j$(nproc) pdo_mysql
RUN docker-php-ext-install -j$(nproc) json
RUN docker-php-ext-install -j$(nproc) intl

RUN curl -sS https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/local/bin/

RUN composer --version
