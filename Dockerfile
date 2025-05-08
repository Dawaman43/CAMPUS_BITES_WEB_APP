# Use the official PHP Apache image
FROM php:8.1-apache

# Enable mod_rewrite for Apache
RUN a2enmod rewrite

# Install PostgreSQL PDO extension
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Copy your project files into the container
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Expose port 80 for Apache
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
