FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update && apt-get install -y cron

COPY ./crontab /etc/cron.d/session-cron

RUN chmod 0644 /etc/cron.d/session-cron && \
    crontab /etc/cron.d/session-cron

RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/html