FROM php:8.2-fpm-alpine

ARG composer_path=/usr/bin/composer
ARG app_path=/var/www

COPY . $app_path
WORKDIR $app_path

RUN apk --no-cache add \
        postgresql-dev libzip-dev libpng-dev \
        libwebp-dev libpng-dev libxpm-dev \
        zip jpegoptim optipng pngquant gifsicle \
        vim unzip curl oniguruma && \
	docker-php-ext-install pdo_pgsql pdo mbstring zip exif pcntl opcache && \
    pecl install -o -f redis && \
    docker-php-ext-enable redis

RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=$composer_path --filename=composer

EXPOSE 9000
CMD ["php-fpm"]
