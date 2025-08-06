FROM ubuntu:24.04

# Suppress interactive prompts
ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update \
 && apt-get install -y --no-install-recommends \
      software-properties-common \
      curl wget git unzip zip gnupg2 lsb-release ca-certificates \
 && add-apt-repository ppa:ondrej/php -y \
 && apt-get update \
 && apt-get install -y --no-install-recommends \
      php8.2-fpm \
      php8.2-mbstring \
      php8.2-xml \
      php8.2-mysql \
      php8.2-gd \
      php8.2-curl \
      php8.2-zip \
 && rm -rf /var/lib/apt/lists/*

RUN sed -i \
      's|^listen = .*$|listen = 0.0.0.0:9000|' \
      /etc/php/8.2/fpm/pool.d/www.conf

# Install Node.js v22 for Vite/Prettier
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get update \
    && apt-get install -y --no-install-recommends nodejs \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www

# Copy application source
COPY src/ /var/www

# Install PHP deps & build assets
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist \
    && npm ci \
    && npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www

# Expose PHP-FPM port
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm8.2", "--nodaemonize"]