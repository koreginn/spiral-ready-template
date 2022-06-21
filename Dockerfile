FROM php:7.4-cli-alpine3.14

RUN php -v
RUN apk update && apk add composer \
  git \
  nano \
  libzip-dev \
  unzip \
  postgresql-dev

# Install PHP Extensions
RUN docker-php-ext-install pdo \
  && docker-php-ext-install pdo_pgsql \
  && docker-php-ext-install pdo_mysql \
  && docker-php-ext-install zip \
  && docker-php-ext-install opcache \
  && docker-php-ext-enable opcache \
  && docker-php-ext-install sockets

# Update Composer
RUN composer self-update --stable
RUN composer -V

WORKDIR /var/www/

RUN chown -R www-data.www-data /var/www/
COPY --chown=www-data /. /var/www/

# Download RoadRunner
RUN composer install && vendor/bin/spiral get-binary -l /usr/local/bin

ENTRYPOINT /var/www/up.sh

EXPOSE 8080
