# Base PHP avec Apache
FROM php:8.2-apache

# Installer extensions PHP nécessaires et client MySQL
RUN apt-get update && apt-get install -y --no-install-recommends \
    mariadb-client \
    unzip \
    git \
    && docker-php-ext-install pdo_mysql zip mysqli \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copier le code du projet
WORKDIR /var/www/html

# Activer le module Apache rewrite
RUN a2enmod rewrite

# Exposer le port 80
EXPOSE 80

# Démarrer Apache
CMD ["apache2-foreground"]
