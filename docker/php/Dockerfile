FROM php:8.5-fpm

# Instala dependências do sistema
# wkhtmltopdf/xvfb removidos: não existem mais nos repositórios do Debian usado por esta imagem
# (projeto arquivado upstream). A geração de PDF via Snappy fica quebrada até a Fase 3 do upgrade
# (migração para Spatie Browsershot), que vai trazer Node/Chromium no lugar.
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo_mysql zip

# Instala o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Define diretório de trabalho
WORKDIR /var/www

USER 1000:1000