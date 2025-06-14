# 1. Base image with Apache & PHP
FROM php:8.2-apache

# 2. System dependencies and PHP extensions
RUN apt-get update \
 && apt-get install -y \
    git zip unzip libzip-dev libonig-dev libxml2-dev libpq-dev \
    nodejs npm \
 && docker-php-ext-install pdo pdo_pgsql mbstring xml zip \
 && a2enmod rewrite

# 3. Configure Apache to use /public as the document root
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# 4. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# 5. Set working directory
WORKDIR /var/www/html

# 6. Copy composer files and example environment
COPY composer.json composer.lock .env.example ./

# 7. Create a temporary .env and install PHP dependencies (skip post-install scripts)
RUN cp .env.example .env \
 && composer install --no-dev --optimize-autoloader --prefer-dist --no-scripts

# 8. Copy the rest of the application
COPY . .

# 9. Generate Laravel application key
RUN php artisan key:generate --force

# 10. Build front-end assets
RUN npm install && npm run build

# 11. Optimize autoload and discover packages
RUN composer dump-autoload --optimize --ansi \
 && php artisan package:discover --ansi

# 12. Fix permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# 13. Entrypoint script (for migrations, storage:link, etc.)
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["entrypoint.sh"]

# 14. Expose port
EXPOSE 80
