FROM php:8.4-fpm-alpine

WORKDIR /var/www

RUN apk add --no-cache \
      bash \
       git \
       curl \
       libpng-dev \
       libjpeg-turbo-dev \
       libwebp-dev \
       libzip-dev \
       icu-dev \
       oniguruma-dev \
       freetype-dev \
       zlib-dev \
       gmp-dev \
       tzdata \
       nginx \
       supervisor \
       procps \
       nodejs \
       npm \
       sqlite-dev \
       postgresql-dev \
       mysql-client \
       openssl \
       libxml2-dev \
       libxslt-dev \
       libffi-dev \
       shadow \
       nano \
       build-base \
       autoconf \
       automake \
       m4

RUN docker-php-ext-install \
    bcmath \
    gd \
    intl \
    mbstring \
    pcntl \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    pdo_sqlite \
    zip \
    gmp \
    exif \
    opcache \
    sockets \
    xml \
    xsl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY ./entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh


EXPOSE 9000

ENTRYPOINT ["entrypoint.sh"]
