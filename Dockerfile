FROM php:8.2-apache

# Copy project files
COPY . /var/www/html/

# Expose port 80
EXPOSE 80

# Apache configuration
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf