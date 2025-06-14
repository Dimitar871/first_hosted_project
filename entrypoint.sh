#!/usr/bin/env bash
set -e

# Remove any baked-in .env so Laravel uses the Render env vars
rm -f /var/www/html/.env

# Run pending migrations against the real DATABASE_URL
php artisan migrate --force

# Ensure storage link
php artisan storage:link || true

# Start Apache
apache2-foreground
