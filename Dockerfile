# Use the official PHP runtime as the base image
FROM php:8.0-fpm

# Set the working directory within the container
WORKDIR /var/www/html

# Copy the composer.json and composer.lock files to the container
COPY composer.json composer.lock /var/www/html/

# Install PHP extensions and dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip && \
    docker-php-ext-configure zip && \
    docker-php-ext-install zip pdo pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the rest of the application code to the container
COPY . /var/www/html

# Install application dependencies using Composer
RUN composer install

# Expose port 9000 to communicate with Render
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
