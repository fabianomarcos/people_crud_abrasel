FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    zip unzip git curl libzip-dev libonig-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libicu-dev libxml2-dev gnupg2 ca-certificates --no-install-recommends \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl intl gd xml \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY .devcontainer/php.ini /usr/local/etc/php/conf.d/99-custom.ini

COPY .devcontainer/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

RUN useradd -m vscode

WORKDIR /workspace

EXPOSE 8000

CMD ["php-fpm"]
