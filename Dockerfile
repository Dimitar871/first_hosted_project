# 1. Base image with Apache & PHP
FROM php:8.2-apache

# 2. System deps & PHP extensions
RUN apt-get update \
 && apt-get install -y \
    git zip unzip libzip-dev libonig-dev libxml2-dev libpq-dev \
    nodejs npm \
 && docker-php-ext-install pdo pdo_pgsql mbstring xml zip \
 && a2enmod rewrite

# 3. Install Composer binary
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Allow Composer as root
ENV COMPOSER_ALLOW_SUPERUSER=1

# 5. Set working dir
WORKDIR /var/www/html

# 6. Copy only composer manifest and example env
COPY composer.json composer.lock .env.example ./

# 7. Seed a temporary .env & install PHP deps without running scripts
RUN cp .env.example .env \
 && composer install --no-dev --optimize-autoloader --prefer-dist --no-scripts

# 8. Copy app code
COPY . .

# 9. Generate key (will be overridden by Render env)
RUN php artisan key:generate --force

# 10. Build front-end assets
RUN npm install && npm run build

# 11. Manually dump autoload & run package discovery now that .env exists
RUN composer dump-autoload --optimize --ansi \
 && php artisan package:discover --ansi

# 12. Fix permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# 13. Entrypoint (migrate + storage link + start Apache)
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["entrypoint.sh"]

# 14. Expose port 80
EXPOSE 80
