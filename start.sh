#!/bin/sh
set -e

echo "=== Etape 1/4 : Migrations ==="
php artisan migrate --force

echo "=== Etape 2/4 : Lien de stockage (fichiers uploades) ==="
php artisan storage:link || true

echo "=== Etape 3/4 : Seeding (roles, permissions, compte admin) ==="
php artisan db:seed --class=RoleSeeder --force

echo "=== Etape 4/4 : Demarrage du serveur ==="
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan serve --host=0.0.0.0 --port=$PORT