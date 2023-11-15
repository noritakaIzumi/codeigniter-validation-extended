FROM php:8.2.12-cli

RUN apt update && \
    apt install -y zip unzip && \
    apt install -y libicu-dev && docker-php-ext-install intl
COPY --from=composer:2.6.5 /usr/bin/composer /usr/bin/composer
