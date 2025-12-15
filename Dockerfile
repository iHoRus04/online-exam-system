# Multi-stage build: Node for frontend assets, then PHP for runtime
FROM node:18 AS node-builder
WORKDIR /app
COPY package*.json ./
RUN npm ci --legacy-peer-deps || npm install
COPY . .
RUN npm run build || echo "No frontend build needed"

# PHP runtime with extensions
FROM php:8.2-fpm
WORKDIR /var/www/html

# Install system dependencies and PHP extensions (added libpq-dev for pgsql)
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    sqlite3 \
    libsqlite3-dev \
    libpq-dev \
    nginx \
    supervisor \
    && docker-php-ext-install pdo_sqlite pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . .

# Copy built frontend assets from node stage
COPY --from=node-builder /app/public /var/www/html/public

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Create SQLite database directory (kept for local/dev fallback)
RUN mkdir -p /var/www/html/database && touch /var/www/html/database/database.sqlite \
    && chown -R www-data:www-data /var/www/html/database \
    && chmod -R 775 /var/www/html/database

# Copy nginx config
COPY docker/nginx.conf /etc/nginx/sites-available/default

# Copy supervisor config
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Copy entrypoint from docker/ and make executable
COPY ./docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Expose port
EXPOSE 8080

# Use our entrypoint, then start supervisord as CMD
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]