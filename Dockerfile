FROM richarvey/nginx-php-fpm:latest

# Set working directory inside container
WORKDIR /var/www/html

# Copy Laravel project into container
COPY . .

# Set correct web root
ENV WEBROOT /var/www/html/public

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Run database migrations
RUN php artisan migrate --force

# Default command starts Nginx + PHP-FPM
CMD ["/start.sh"]
