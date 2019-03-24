FROM php:7.1-apache

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        # libpng12-dev \
        libz-dev \
    && docker-php-ext-install -j$(nproc) iconv \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install -j$(nproc) zip
    
RUN requirements="libmcrypt-dev g++ libicu-dev libpq-dev" \
    && apt-get update && apt-get install -y $requirements && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mcrypt \
    && docker-php-ext-install mbstring \
    && docker-php-ext-install intl \
    && docker-php-ext-install opcache \
    && docker-php-ext-install json \
    && requirementsToRemove="g++" \
    && apt-get purge --auto-remove -y $requirementsToRemove

RUN pecl install xdebug-2.5.0 \
    && docker-php-ext-enable xdebug

RUN a2enmod rewrite && service apache2 restart

COPY . /var/www/html

EXPOSE 80