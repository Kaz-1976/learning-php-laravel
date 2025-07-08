FROM php:8.3-fpm-bookworm
EXPOSE 9000
COPY ./container/app/php.ini /usr/local/etc/php/
RUN apt update && apt upgrade -y && apt install -y unzip graphviz fontconfig fonts-noto-cjk fonts-noto-cjk-extra
RUN docker-php-ext-install pdo_mysql
WORKDIR /var/www/html/
