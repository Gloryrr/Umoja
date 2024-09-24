# Utiliser l'image PHP avec l'extension nécessaire
FROM php:8.1-fpm

# Installer les dépendances système et les extensions PHP nécessaires
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpq-dev \
    libcurl4-openssl-dev \
    zlib1g-dev \
    libxml2-dev \
    libonig-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql curl mbstring xml zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Créer et définir le répertoire de travail
WORKDIR /app/saas/backend/

# Copier le reste du code de votre application avant d'installer Composer
COPY . .

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installer les dépendances avec Composer
RUN composer install --optimize-autoloader

# Exposer le port 9000 pour PHP-FPM
EXPOSE 9000

# Démarrer PHP-FPM
CMD ["php-fpm"]