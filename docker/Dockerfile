# Dockerfile для php
FROM php:8.4-fpm

# Установка расширения pgsql и pdo_pgsql
RUN apt-get update && apt-get install -y libpq-dev \
&& docker-php-ext-install pdo_pgsql pgsql
