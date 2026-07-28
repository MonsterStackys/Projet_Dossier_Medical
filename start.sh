#!/bin/sh
set -e

echo "=== Étape 1/3 : Migrations ==="
php artisan migrate --force

echo "=== Étape 2/3 : Seeding (rôles, permissions, compte admin) ==="
php artisan db:seed --class=RoleSeeder --force

echo "=== Étape 3/3 : Démarrage du serveur ==="
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan serve --host=0.0.0.0 --port=$PORT