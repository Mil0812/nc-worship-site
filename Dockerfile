#FROM ubuntu:latest
#LABEL authors="admin"
#
#ENTRYPOINT ["top", "-b"]

 FROM php:8.3-fpm

 WORKDIR /var/www

 RUN apt-get update && apt-get install -y \
     libpng-dev \
     libonig-dev \
     libxml2-dev \
     libzip-dev \
     zip \
     unzip \
     git \
     curl \
     nginx \
     && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd \
     && apt-get clean && rm -rf /var/lib/apt/lists/*

 RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

 COPY . .

 RUN composer install --no-interaction --optimize-autoloader --no-dev

  RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - \
     && apt-get install -y nodejs \
     && npm install && npm run build

 RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
 RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

 COPY ./docker/nginx.conf /etc/nginx/sites-available/default

 EXPOSE 80

 CMD service nginx start && php-fpm
