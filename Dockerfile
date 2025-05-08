# Use the official PHP Apache image
FROM php:8.1-apache

# Enable mod_rewrite for Apache
RUN a2enmod rewrite

# Copy the project files into the container
COPY . /var/www/html/

# Set working directory to the project folder
WORKDIR /var/www/html

# Install dependencies if needed (for example, if you use MySQL or other PHP extensions)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Expose port 80 for Apache
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
