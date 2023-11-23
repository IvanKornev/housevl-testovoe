FROM composer:2.4.4 AS composer
FROM php:8.2-fpm-alpine

ARG composer_path=/usr/bin/composer
ARG app_path=/var/www

COPY ./docker/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY . $app_path
WORKDIR $app_path

RUN apk --no-cache add \
        postgresql-dev libzip-dev libpng-dev \
        libwebp-dev linux-headers libpng-dev libxpm-dev \
        zip jpegoptim optipng pngquant gifsicle \
        vim unzip curl oniguruma-dev pcre-dev ${PHPIZE_DEPS} && \
	docker-php-ext-install pdo_pgsql pdo mbstring zip exif pcntl opcache && \
    pecl install -o -f redis xdebug && \
    docker-php-ext-enable redis xdebug && \
    apk del pcre-dev ${PHPIZE_DEPS} && \
    rm -rf /var/cache/apk/*

COPY --from=composer $composer_path $composer_path
EXPOSE 9000
CMD ["php-fpm"]
