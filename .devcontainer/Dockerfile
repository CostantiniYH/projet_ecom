# Base PHP avec Apache
FROM php:8.2-apache

# Installer utilitaires système et extensions PHP nécessaires
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    vim \
    less \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    mariadb-client \
    curl \
    gnupg2 \
    lsb-release \
    software-properties-common \
    apt-transport-https \
    ca-certificates \
    sudo \
    && docker-php-ext-install pdo_mysql zip mysqli \
    && rm -rf /var/lib/apt/lists/*

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Installer Docker CLI
RUN curl -fsSL https://download.docker.com/linux/debian/gpg | gpg --dearmor -o /usr/share/keyrings/docker-archive-keyring.gpg \
    && echo "deb [arch=amd64 signed-by=/usr/share/keyrings/docker-archive-keyring.gpg] https://download.docker.com/linux/debian $(lsb_release -cs) stable" > /etc/apt/sources.list.d/docker.list \
    && apt-get update && apt-get install -y docker-ce-cli \
    && rm -rf /var/lib/apt/lists/*

# Copier le code du projet dans le conteneur
WORKDIR /var/www/html
COPY . /var/www/html

# Activer les modules Apache nécessaires
RUN a2enmod rewrite

# Exposer le port 80
EXPOSE 80

# Commande par défaut
CMD ["apache2-foreground"]
