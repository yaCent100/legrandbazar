FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libicu-dev libonig-dev zip unzip git curl libzip-dev \
    && docker-php-ext-install intl pdo pdo_mysql zip opcache

RUN a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/www/html

WORKDIR /var/www/html

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

COPY apache.conf /etc/apache2/sites-available/000-default.conf
