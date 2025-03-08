FROM php:8.3Z-fpm-bookworm
EXPOSE 9000
COPY ./container/app/php.ini /usr/local/etc/php/
RUN apt update && apt upgrade -y && apt install -y unzip
RUN docker-php-ext-install pdo_mysql
WORKDIR /var/www/html/
