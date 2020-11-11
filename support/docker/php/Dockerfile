FROM php:7.4-fpm

LABEL maintainer="rsurfings@gmail.com"

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    openssl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version


# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# install xdebug
RUN yes | pecl install xdebug
RUN docker-php-ext-enable xdebug

# Instalação e configuração do XDebug
RUN echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_handler=dbgp" >>  /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_port=9001" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_connect_back=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.idekey=docker" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_log=/tmp/xdebug.log" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.default_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www/

USER $user