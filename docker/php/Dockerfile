FROM php:8.2-fpm-alpine

ARG composer_path=/usr/bin/composer

COPY . /var/www
WORKDIR /var/www

RUN apk --no-cache add \
        postgresql-dev libzip-dev libpng-dev \
        libwebp-dev libpng-dev libxpm-dev \
        zip jpegoptim optipng pngquant gifsicle \
        vim unzip curl \
	&& docker-php-ext-install pdo_pgsql pdo mbstring zip exif pcntl opcache \

RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=$composer_path --filename=composer

EXPOSE 9000
CMD ["php-fpm"]
