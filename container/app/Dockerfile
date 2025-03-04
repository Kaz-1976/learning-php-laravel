FROM php:8.3-fpm-bookworm
EXPOSE 5173
COPY ./container/app/php.ini /usr/local/etc/php/
RUN apt update && apt upgrade -y && apt install -y unzip
RUN docker-php-ext-install pdo_mysql
RUN cd /usr/bin && curl -s http://getcomposer.org/installer | php && ln -s /usr/bin/composer.phar /usr/bin/composer
WORKDIR /var/www/html/
ENTRYPOINT [ "bash", "-c", "composer install; exec php-fpm" ]