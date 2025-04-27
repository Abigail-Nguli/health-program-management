FROM php:8.2-apache

# Install PostgreSQL support
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql

# Configure PHP
RUN echo "extension=pdo_pgsql" >> /usr/local/etc/php/conf.d/pdo_pgsql.ini
RUN echo "extension=pgsql" >> /usr/local/etc/php/conf.d/pgsql.ini

# Copy project files
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

EXPOSE 80