#!/usr/bin/env bash
set -e

# Run pending migrations
php artisan migrate --force

# Ensure storage link
php artisan storage:link || true

# Finally start Apache
apache2-foreground
