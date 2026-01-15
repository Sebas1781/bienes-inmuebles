FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    sqlite3 \
    libsqlite3-dev

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_sqlite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy application files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Create SQLite database
RUN touch database/database.sqlite

# Set permissions
RUN chmod -R 775 storage bootstrap/cache database

# Expose port
EXPOSE 8080

# Start command
CMD touch database/database.sqlite && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=8080
