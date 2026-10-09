#!/bin/sh
# Script de démarrage du conteneur (utilisé par Render).
set -e

cd /var/www/html

# L'hébergeur fournit le port d'écoute dans $PORT (80 par défaut)
PORT="${PORT:-80}"
sed -ri "s/Listen [0-9]+/Listen ${PORT}/" /etc/apache2/ports.conf
sed -ri "s/<VirtualHost \*:[0-9]+>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# Base SQLite de démonstration, recréée à chaque démarrage
if [ "${DB_CONNECTION:-sqlite}" = "sqlite" ]; then
    export DB_DATABASE="${DB_DATABASE:-/var/www/html/database/database.sqlite}"
    touch "$DB_DATABASE"
    chown www-data:www-data "$DB_DATABASE"
fi

# Clé de chiffrement Laravel : générée au démarrage si aucune n'est fournie
if [ -z "${APP_KEY}" ]; then
    export APP_KEY="$(php artisan key:generate --show --no-ansi)"
fi

php artisan storage:link || true
php artisan config:cache
php artisan route:cache
php artisan view:cache

if [ "${DEMO_RESET_ON_START:-true}" = "true" ]; then
    php artisan migrate:fresh --seed --force
else
    php artisan migrate --force
fi

chown -R www-data:www-data storage bootstrap/cache database

exec apache2-foreground
