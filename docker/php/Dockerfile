FROM php:8.3-fpm

# Sistem bağımlılıkları
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip

# Composer yükle
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# PHP ayar dosyasını kopyala
COPY php.ini /usr/local/etc/php/

# Çalışma dizini
WORKDIR /var/www

# www-data kullanıcısını ayarla
RUN chown -R www-data:www-data /var/www

USER www-data

# Eksik olan
EXPOSE 9000
