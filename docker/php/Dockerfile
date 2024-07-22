FROM php:8.3-fpm-bookworm
COPY ./docker/php/php.ini /usr/local/etc/php/
RUN docker-php-ext-install pdo_mysql
WORKDIR /var/www/html/
