FROM php:8.3-fpm-bookworm
# EXPOSE 5173
EXPOSE 9000
COPY ./container/app/php.ini /usr/local/etc/php/
RUN docker-php-ext-install pdo_mysql
WORKDIR /var/www/html/
