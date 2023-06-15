FROM php:8.0-apache

COPY php.ini ./php.ini

# Setting up htaccess
COPY custom.conf /etc/apache2/sites-available/000-default.conf
COPY .htaccess /var/www/html/.htaccess
RUN a2enmod rewrite

RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    nano \
    && rm -r /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html
