FROM php:7.4-apache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get update && apt-get install -y git libzip-dev unzip \
    && docker-php-ext-install zip pdo_mysql mysqli  \
    && a2enmod rewrite headers

COPY ./MoviesBackend /var/www/html/

EXPOSE 80

WORKDIR /var/www/html/

RUN composer install