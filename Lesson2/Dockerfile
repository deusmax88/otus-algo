FROM php:7.4-cli

RUN apt update && \
    apt install -y libuv1-dev libzip-dev git

RUN pecl install xdebug-3.1.5 && \
    docker-php-ext-enable xdebug
RUN pecl install uv-beta && \
    docker-php-ext-enable uv

RUN docker-php-ext-install zip pcntl

COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

COPY download-and-install-composer.sh download-and-install-composer.sh

RUN ./download-and-install-composer.sh

RUN rm download-and-install-composer.sh

RUN chmod +x composer.phar && mv composer.phar /usr/local/bin/composer




