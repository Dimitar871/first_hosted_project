#!/usr/bin/env bash
set -e

# Run migrations
php artisan migrate --force

# Ensure storage symlink
php artisan storage:link || true

# Start Apache in foreground
apache2-foreground
