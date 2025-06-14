# 1. Base image with Apache & PHP 8.2
FROM php:8.2-apache

# 2. System deps & PHP extensions
RUN apt-get update \
 && apt-get install -y \
    git zip unzip libzip-dev libonig-dev libxml2-dev libpq-dev \
    nodejs npm \
 && docker-php-ext-install pdo pdo_pgsql mbstring xml zip

# 3. Enable mod_rewrite for pretty URLs
RUN a2enmod rewrite

# 4. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Set working dir
WORKDIR /var/www/html

# 6. Copy composer files & install PHP deps
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --prefer-dist

# 7. Copy the rest of the app
COPY . .

# 8. Copy env example and generate key (Render ENV will override)
RUN cp .env.example .env \
 && php artisan key:generate

# 9. Build front-end assets
RUN npm install \
 && npm run build

# 10. Fix permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# 11. Entrypoint: run migrations then start Apache
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["entrypoint.sh"]

# 12. Expose port 80
EXPOSE 80
