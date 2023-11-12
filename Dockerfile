# Stage 1: Build the PHP-FPM image for the Laravel application
FROM php:8.1-apache as app

# Set the working directory in the container
WORKDIR /var/www/html

# Install Node.js and npm
RUN apt-get update && \
    apt-get install -y nodejs && \
    apt-get install -y npm


# Install PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libgd-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the application files to the container
COPY . .

# Ensure the storage directory and its subdirectories have the correct permissions
RUN mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache \
    && chown -R www-data:www-data storage \
    && chmod -R 775 storage \
    && mkdir -p bootstrap/cache \
    && chown -R www-data:www-data bootstrap/cache \
    && chmod -R 775 bootstrap/cache

# Set the correct permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Install application dependencies
RUN composer install --optimize-autoloader --no-dev

# Set environment variables
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
ENV DB_CONNECTION=mysql
ENV DB_HOST=mysql
ENV DB_PORT=3306
ENV DB_DATABASE=laravel
ENV DB_USERNAME=root
ENV DB_PASSWORD=secret

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set up the virtual host configuration
COPY docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Set up the entrypoint script
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

# Expose port 8080
EXPOSE 80

# Set labels
LABEL maintainer="Your Name <your-email@example.com>"
LABEL version="1.0"
LABEL description="Docker image for running Laravel app with MySQL"

# Start Apache server
CMD ["apache2-foreground", "npm run dev"]



FROM httpd:2.4 as webserver

# Copy Apache configuration file into the container
COPY docker/apache.conf /usr/local/apache2/conf/apache.conf

# Include custom Apache configuration
RUN echo "Include /usr/local/apache2/conf/apache.conf" \
    >> /usr/local/apache2/conf/httpd.conf

# Copy the storage directory from the app stage
COPY --from=app /var/www/html/storage /var/www/html/storage

EXPOSE 8080