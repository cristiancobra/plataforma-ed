FROM php:8.5-fpm

# Instala dependências do sistema
# wkhtmltopdf/xvfb removidos: não existem mais nos repositórios do Debian usado por esta imagem
# (projeto arquivado upstream). Node + Chromium entram no lugar, para o Spatie Browsershot
# (geração de PDF via Chrome headless, ver app/Helpers/Functions.php::pdfFromView()).
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
    nodejs npm chromium \
    fonts-liberation libnss3 libatk-bridge2.0-0 libxkbcommon0 libgtk-3-0 \
    libxss1 libasound2 libgbm1 \
    && docker-php-ext-install pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# node_modules do Browsershot (puppeteer — o script do Browsershot exige esse pacote, não o
# puppeteer-core — mas pulamos o download do Chromium bundled dele, usamos o do apt acima),
# isolado do node_modules do front-end (gerenciado pelo container `node`, ver webpack.mix.js).
RUN mkdir -p /opt/browsershot && \
    cd /opt/browsershot && \
    PUPPETEER_SKIP_DOWNLOAD=true npm install puppeteer@23 && \
    chmod -R a+rX /opt/browsershot

# Instala o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Define diretório de trabalho
WORKDIR /var/www

USER 1000:1000