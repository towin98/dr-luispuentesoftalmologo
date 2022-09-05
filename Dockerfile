FROM php:8.0-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y libpq-dev jq\
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip\
&& docker-php-ext-configure gd --with-freetype --with-jpeg \
&& docker-php-ext-install -j$(nproc) gd


# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath


# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# COPY ./ /var/www/
#RUN cp docker-compose/php/php.ini /usr/local/etc/php/conf.d/app.ini
#RUN cp docker/nginx.conf /etc/nginx/sites-enabled/default

# Set working directory
WORKDIR /var/www
# RUN composer install --optimize-autoloader --no-dev

USER $user
