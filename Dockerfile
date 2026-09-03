FROM php:8.3-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libwebp-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    nodejs \
    npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Provide a dummy .env so artisan commands can bootstrap during build
RUN cp .env.example .env

# Install PHP dependencies (--no-scripts prevents package:discover from running
# before a valid environment/database is available)
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Install and build frontend assets
RUN npm install && npm run build

# Create storage directories and set permissions
RUN mkdir -p storage/app/public storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs \
    && mkdir -p bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Link storage (safe to run during build; only creates a symlink)
RUN php artisan storage:link || true

EXPOSE 8080

# Do NOT run config:cache or optimize at build time — they bake env values
# into cached files before Render injects runtime environment variables.
# Laravel reads fresh .env / env vars on every request by default.
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]
