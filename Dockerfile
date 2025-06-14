# 1. Base image with Apache & PHP
FROM php:8.2-apache

# 2. System dependencies & PHP extensions
RUN apt-get update \
 && apt-get install -y \
    git zip unzip libzip-dev libonig-dev libxml2-dev libpq-dev \
    nodejs npm \
 && docker-php-ext-install pdo pdo_pgsql mbstring xml zip \
 && a2enmod rewrite

# 3. Install Composer (from the official Composer image)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Allow Composer plugins to run as root
ENV COMPOSER_ALLOW_SUPERUSER=1

# 5. Set working directory
WORKDIR /var/www/html

# 6. Copy only composer files + example env
COPY composer.json composer.lock .env.example ./

# 7. Seed a real .env and install PHP dependencies (including post-install scripts)
RUN cp .env.example .env \
 && composer install --no-dev --optimize-autoloader --prefer-dist

# 8. Copy the rest of your application code
COPY . .

# 9. Generate the application key (will use the key in env.example, overridden in Render)
RUN php artisan key:generate --force

# 10. Build front-end assets
RUN npm install \
 && npm run build

# 11. Fix permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# 12. Entrypoint script (runs migrations & storage link before starting Apache)
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["entrypoint.sh"]

# 13. Expose port 80
EXPOSE 80
