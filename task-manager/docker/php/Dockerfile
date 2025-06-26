FROM php:8.2-apache

# Instalar dependências e extensões necessárias para o PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    libicu-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install intl pdo pdo_pgsql pgsql zip

RUN docker-php-ext-install opcache

# Configurar o Apache para utilizar o diretório público
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Ajustar configurações do Apache (como root)
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Habilitar rewrite do Apache
RUN a2enmod rewrite

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Garante que a pasta writable/cache exista e tenha permissão de escrita
RUN mkdir -p writable/cache && chown -R www-data:www-data writable

# Só agora muda para o usuário www-data
USER www-data