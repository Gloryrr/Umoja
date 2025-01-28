FROM php:8.1-fpm

# Installer les dépendances système et les extensions PHP nécessaires
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    libpq-dev \
    libcurl4-openssl-dev \
    zlib1g-dev \
    libxml2-dev \
    libonig-dev \
    libzip-dev \
    wrk \
    && docker-php-ext-install pdo pdo_pgsql curl mbstring xml zip intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Créer et définir le répertoire de travail
WORKDIR /app/saas/backend/

# Copier le code de l'application avant d'installer Composer
COPY . .

# Installer Composer avec vérification
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer --version

# Installer les dépendances avec Composer
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --optimize-autoloader

# Vérification des fichiers clés
RUN ls -l /app/saas/backend/composer.json

# Exposer le port 9000 pour PHP-FPM
EXPOSE 9000

# Démarrer PHP-FPM
CMD ["php-fpm"]
