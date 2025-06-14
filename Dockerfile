# 1. Base image with Apache & PHP
FROM php:8.2-apache

# 2. System deps & PHP extensions
RUN apt-get update \
 && apt-get install -y \
    git zip unzip libzip-dev libonig-dev libxml2-dev libpq-dev \
    nodejs npm \
 && docker-php-ext-install pdo pdo_pgsql mbstring xml zip \
 && a2enmod rewrite

# 3. Point Apache at public/
RUN sed -ri \
    -e 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/*.conf

# 4. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

# 5. Working directory
WORKDIR /var/www/html

# 6. Copy composer files + example env
COPY composer.json composer.lock .env.example ./

# 7. Temp .env & composer install (no scripts)
RUN cp .env.example .env \
 && composer install --no-dev --optimize-autoloader --prefer-dist --no-scripts

# 8. Copy app code
COPY . .

# 9. Key generate
RUN php artisan key:generate --force

# 10. Frontend build
RUN npm install && npm run build

# 11. Autoload & package discovery
RUN composer dump-autoload --optimize --ansi \
 && php artisan package:discover --ansi

# 12. Permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# 13. Entrypoint
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["entrypoint.sh"]

# 14. Expose port
EXPOSE 80
