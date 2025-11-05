# ==============================
#  Symfony + Apache + PHP + MySQL
# ==============================

# Use PHP 8.2 with Apache
FROM php:8.2-apache

# Enable Apache mod_rewrite (needed for Symfony routes)
RUN a2enmod rewrite

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install intl pdo pdo_mysql zip gd \
    && rm -rf /var/lib/apt/lists/*

# Install Composer globally
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory inside the container
WORKDIR /var/www/html

# Copy existing project files to the container
COPY . .

# Install Symfony dependencies
RUN composer install --no-interaction --optimize-autoloader

# Adjust permissions for Symfony cache and logs
RUN mkdir -p var/cache var/log && chown -R www-data:www-data var

# Configure Apache DocumentRoot for Symfony's public directory
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Expose port 80 for Apache
EXPOSE 80

# Warm up Symfony cache
RUN php bin/console cache:warmup

# Start Apache
CMD ["apache2-foreground"]