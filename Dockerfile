# ---------------------------------------------------------------------
# Étape 0 : application Flutter (version web), servie sur /app/
# Le code est récupéré depuis le dépôt de l'application.
# ---------------------------------------------------------------------
FROM ghcr.io/cirruslabs/flutter:3.27.1 AS flutter
ARG FLUTTER_APP_REPO=https://github.com/peace042005/Tickify.git
ARG FLUTTER_APP_BRANCH=main
RUN git clone --depth 1 --branch ${FLUTTER_APP_BRANCH} ${FLUTTER_APP_REPO} /tickify
WORKDIR /tickify
RUN flutter pub get && flutter build web --release --base-href /app/

# ---------------------------------------------------------------------
# Étape 1 : compilation du front (React + Vite)
# ---------------------------------------------------------------------
FROM node:20-alpine AS front
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY vite.config.js tailwind.config.js postcss.config.js ./
COPY resources ./resources
RUN npm run build

# ---------------------------------------------------------------------
# Étape 2 : dépendances PHP (sans les outils de développement)
# ---------------------------------------------------------------------
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --no-interaction --prefer-dist --ignore-platform-reqs

# ---------------------------------------------------------------------
# Étape 3 : image finale PHP 8.3 + Apache
# ---------------------------------------------------------------------
FROM php:8.3-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends libsqlite3-dev libzip-dev unzip \
    && docker-php-ext-install pdo_sqlite pdo_mysql zip \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

# Apache sert le dossier public/ de Laravel
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf /etc/apache2/apache2.conf \
    && sed -ri 's!AllowOverride None!AllowOverride All!g' /etc/apache2/apache2.conf

WORKDIR /var/www/html
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=front /app/public/build ./public/build
COPY --from=flutter /tickify/build/web ./public/app

RUN composer dump-autoload --optimize --no-dev \
    && chown -R www-data:www-data storage bootstrap/cache database

COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

CMD ["start.sh"]
