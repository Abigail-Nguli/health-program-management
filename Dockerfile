FROM php:8.2-apache

# Install required extensions (customize as needed)
RUN docker-php-ext-install pdo pdo_mysql

# Copy project files
COPY . /var/www/html/

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html

# Enable Apache rewrite module
RUN a2enmod rewrite

# Expose port 80
EXPOSE 80