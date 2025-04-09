FROM php:8.2-apache


# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
  libzip-dev \
  unzip \
  && docker-php-ext-install \
  pdo_mysql \
  zip \
  opcache

# Suppress AH00558 warning by setting ServerName
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

WORKDIR /var/www/html

# Step 3: Copy the application files into the container
COPY app/ .

RUN chown -R www-data:www-data /var/www \
  && a2enmod rewrite
  
RUN docker-php-ext-install mysqli
# Install Composer (if needed)
EXPOSE 80
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

