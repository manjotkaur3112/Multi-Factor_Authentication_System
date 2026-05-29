FROM php:8.1-alpine

WORKDIR /app

# Install system dependencies
RUN apk add --no-cache \
    git \
    zip \
    unzip \
    curl

# Install PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose port
EXPOSE 8080

# Run PHP built-in server
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
