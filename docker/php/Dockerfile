FROM php:8.0-fpm

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
    wkhtmltopdf xvfb libxrender1 libfontconfig1 \
    && docker-php-ext-install pdo_mysql zip

# Instala o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Define diretório de trabalho
WORKDIR /var/www

USER 1000:1000