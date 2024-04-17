FROM ubuntu:22.04

# dependency installation
RUN apt-get update && apt-get install -y \
    curl \
    php \
    php-mysql

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/user/local/bin --filename=composer

WORKDIR /var/www/html

# Copy existing application directory contents
COPY . /var/www/html/

# Install dependencies
RUN composer install

# Expost port 8000
EXPOSE 8000

#Start PHP
CMD php artisan serve --host=0.0.0.0 --port=8000