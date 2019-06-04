FROM php:7.2-apache

# Composer.
RUN cd /usr/bin && curl -s http://getcomposer.org/installer | php && ln -s /usr/bin/composer.phar /usr/bin/composer

# Extensions.
RUN apt-get update && apt-get install -y \
  git \
  zip \
  unzip \
  vim \
  libpq-dev \
  zlib1g-dev \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  libpng-dev \
  libmcrypt-dev \
  libzip-dev \
  && pecl install mcrypt-1.0.1 \
  && docker-php-ext-enable mcrypt \
  && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
  && docker-php-ext-install -j$(nproc) gd \
  && docker-php-ext-install pdo_mysql pdo_pgsql
RUN apt-get update && \
  apt-get install apt-utils curl gnupg cmake -y && \
  mkdir /tmp/libzip && cd /tmp/libzip && curl -sSLO https://libzip.org/download/libzip-1.4.0.tar.gz && \
  tar zxf libzip-1.4.0.tar.gz && cd libzip-1.4.0/ && mkdir build && cd build && cmake ../ && \
  make > /dev/null && make install && \
  docker-php-ext-configure zip --with-libzip=/usr/local/lib/libzip.so && \
  docker-php-ext-install zip

# Set php.ini
RUN cp -f /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
RUN sed -i -e "s|;mbstring.language = Japanese|mbstring.language = Japanese|" /usr/local/etc/php/php.ini \
  && sed -i -e "s|;mbstring.internal_encoding = EUC-JP|mbstring.internal_encoding = UTF-8|" /usr/local/etc/php/php.ini \
  && sed -i -e "s|;mbstring.http_input = auto|mbstring.http_input = auto|" /usr/local/etc/php/php.ini \
  && sed -i -e "s|;mbstring.detect_order = auto|mbstring.detect_order = auto|" /usr/local/etc/php/php.ini \
  && sed -i -e "s|expose_php = On|expose_php = Off|" /usr/local/etc/php/php.ini \
  && sed -i -e "s|;date.timezone =|date.timezone = Asia/Tokyo|" /usr/local/etc/php/php.ini \
  && sed -i -e "s|display_errors = Off|display_errors = On|" /usr/local/etc/php/php.ini \
  && sed -i -e "s|post_max_size = 8M|post_max_size = 100M|" /usr/local/etc/php/php.ini \
  && sed -i -e "s|upload_max_filesize = 2M|upload_max_filesize = 100M|" /usr/local/etc/php/php.ini

# Set openssl.
RUN apt-get update && apt-get install -y \
  libssl-dev \
  openssl \
  ssl-cert \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* \
  && a2enmod ssl \
  && a2ensite default-ssl

# Set environments.
ARG DOMAIN
ARG CREDENTIAL
ARG WEB_ROOT

RUN echo "export DOMAIN='${DOMAIN}'" >> /etc/apache2/envvars
RUN echo "export CREDENTIAL='${CREDENTIAL}'" >> /etc/apache2/envvars
RUN echo "export WEB_ROOT='${WEB_ROOT}'" >> /etc/apache2/envvars
RUN service apache2 restart

WORKDIR /var/www