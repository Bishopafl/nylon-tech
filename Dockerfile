FROM ubuntu:latest

# Set non-interactive installation - this was throwing and error for me upon installation
ENV DEBIAN_FRONTEND=noninteractive 
ENV TZ=Etc/UTC

# dependency installation
RUN apt-get update && apt-get install -y \
    libxml2-dev \
    curl \
    libcurl4-openssl-dev \
    php \
    php-cli \
    php-pdo \
    php-mysql \
    php-xml \
    php-curl \
    php-zip \
    zip \
    unzip \
    git \
    sudo \
    php-mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*    
    #minimize layers and reduce packages

WORKDIR /var/www/html

# Copy existing application directory contents
COPY . /var/www/html/

# Install Composer 
COPY --from=composer /usr/bin/composer /usr/bin/composer

#install composer as non-root user (www-data) to avoid permission issues 
RUN chown -R www-data:www-data /var/www/html && \
    sudo -u www-data composer install --no-interaction --no-plugins --ignore-platform-reqs

# Expose port 8000
EXPOSE 8000

#Start PHP
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]