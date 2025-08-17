FROM php:8.3-apache

RUN apt-get update \
    && apt-get install -y build-essential curl zlib1g-dev g++ git libicu-dev zip libzip-dev libpng-dev libjpeg-dev libwebp-dev libfreetype6-dev \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

RUN docker-php-ext-configure gd --with-freetype --with-webp --with-jpeg \
    && docker-php-ext-install  gd \
    && docker-php-ext-install exif

RUN a2enmod rewrite && a2enmod ssl && a2enmod socache_shmcb

# Install composer
# COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Copy php settings
COPY ./php.ini ${PHP_INI_DIR}/conf.d/99-php.ini

# Copy entrypoint
COPY ./entrypoint /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint

WORKDIR /var/www

RUN curl -sL https://deb.nodesource.com/setup_20.x | bash \
    && apt-get install nodejs -y

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# RUN curl -sS https://get.symfony.com/cli/installer | bash
# RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

RUN git config --global user.email "aziaha.formations@gmail.com"
RUN git config --global user.name "Jean-Claude AZIAHA"








# FROM php:8.2-apache

# # Met à jour les paquets et installe les extensions PHP et outils requis
# RUN apt-get update && apt-get upgrade -y \
#     && apt-get install -y \
#        libzip-dev \
#        unzip \
#        git \
#     && docker-php-ext-install mysqli pdo pdo_mysql zip \
#     && docker-php-ext-enable mysqli pdo_mysql zip \
#     \
#     && curl -sS https://getcomposer.org/installer | php -- \
#     && mv composer.phar /usr/local/bin/composer \
#     \
#     && apt-get clean \
#     && rm -rf /var/lib/apt/lists/*

# EXPOSE 80