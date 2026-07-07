FROM php:8.3-cli

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    ffmpeg \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev

# Configure GD
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

# Install PHP extensions
RUN docker-php-ext-install \
    gd \
    pdo \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy project
COPY . .

# Allow composer as root
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install dependencies
RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader

# Storage link
RUN php artisan storage:link || true

EXPOSE 10000

CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"]
