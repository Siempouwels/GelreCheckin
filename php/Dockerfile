FROM php:8.0-apache

COPY php.ini ./php.ini

RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    && rm -r /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
