# Utiliser l'image PHP avec l'extension nécessaire
FROM php:8.1-fpm

# Installer les dépendances système et les extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    git \
    libpq-dev \
    libcurl4-openssl-dev \
    zlib1g-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_pgsql curl mbstring xml bcmath ctype

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