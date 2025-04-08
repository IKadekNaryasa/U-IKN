# Gunakan image PHP resmi
FROM php:8.2-fpm

# Install dependency OS dan ekstensi PHP yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    zip unzip curl git libpng-dev libonig-dev libxml2-dev \
    libzip-dev libpq-dev libjpeg-dev libfreetype6-dev libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set direktori kerja
WORKDIR /var/www

# Copy semua file project ke dalam container
COPY . /var/www

# Install dependency Laravel
RUN composer install --no-dev --optimize-autoloader

# Set permission
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

# Jalankan Laravel di port 8080
CMD php artisan serve --host=0.0.0.0 --port=8080
