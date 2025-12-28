FROM php:8.2-apache

# Installer extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql zip mysqli

# Apache rewrite (souvent utile)
RUN a2enmod rewrite

# Installer utilitaires essentiels : git, unzip, MySQL client
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    mariadb-client \
    libmariadb3 libssl1.1 \
    && rm -rf /var/lib/apt/lists/*

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Définir le dossier de travail
WORKDIR /var/www/html
