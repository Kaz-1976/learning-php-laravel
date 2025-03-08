FROM php:8.4-fpm-bookworm
EXPOSE 5173
EXPOSE 9000
COPY ./container/app/php.ini /usr/local/etc/php/
RUN apt update && apt upgrade -y && apt install -y unzip
RUN docker-php-ext-install pdo_mysql
RUN cd /usr/bin && curl -s http://getcomposer.org/installer | php && ln -s /usr/bin/composer.phar /usr/bin/composer
# RUN cd /var/www/html && composer install
WORKDIR /var/www/html/
