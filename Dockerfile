FROM 289208114389.dkr.ecr.us-east-1.amazonaws.com/picpay/php:8.1.7-fpm-grpc-base

WORKDIR /app

ARG COMPOSER_AUTH
ENV COMPOSER_AUTH $COMPOSER_AUTH

RUN apk add --no-cache \
    bash \
    curl \
    git \
    libzip-dev \
    nginx \
    supervisor \
    zip \
    && rm -rf /var/cache/apk/*


RUN pecl install xdebug-3.1.6 \
    && docker-php-ext-enable xdebug \
    && echo "opcache.validate_timestamps=1" >> /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini;

# This allows beta pecl install
RUN pear config-set preferred_state beta \
    && pecl install opentelemetry \
    && pear config-set preferred_state stable

RUN docker-php-ext-install pdo mysqli pdo_mysql mbstring && \
    docker-php-ext-enable pdo mysqli pdo_mysql mbstring opentelemetry

#COPY --from=composer/composer:latest-bin /composer /usr/bin/composer
RUN composer self-update --2

# configs files
COPY --chown=www-data:www-data . /app/
COPY docker/config/         /
COPY docker/config/etc/php7/php.ini /usr/local/etc/php/php.ini

COPY docker-entrypoint.sh /
RUN chmod +x /docker-entrypoint.sh

ENTRYPOINT ["/docker-entrypoint.sh"]
