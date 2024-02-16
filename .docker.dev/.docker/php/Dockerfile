ARG PHP_VERSION

FROM php:${PHP_VERSION}-fpm

ARG DOCKER_DIR_PROJECT
ARG DOCKER_CONTAINER_NAME
ARG NODE_VERSION

RUN apt-get update \
    && apt-get install -y --no-install-recommends vim curl debconf subversion git apt-transport-https apt-utils \
    build-essential locales acl mailutils wget unzip \
    gnupg gnupg1 gnupg2 \
    gcc make autoconf libc-dev pkg-config libmemcached-dev libpng-dev libicu-dev libxml2-dev \
    libzip-dev zlib1g-dev \
    yarn nano cron  supervisor mariadb-client \
    && docker-php-ext-configure intl \
    && docker-php-ext-install zip mysqli pdo pdo_mysql gd intl xml xmlwriter soap \
    && docker-php-ext-enable soap

COPY php.ini /etc/php/${PHP_VERSION}/php.ini
COPY php.ini /usr/local/etc/php/php.ini
COPY php-fpm-pool.conf /etc/php/${PHP_VERSION}/pool.d/www.conf

#RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
#    mv composer.phar /usr/local/bin/composer
RUN curl -sSk https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

#RUN docker-php-ext-configure opcache --enable-opcache \
#    && docker-php-ext-install opcache

#INSTALL APCU
RUN pecl channel-update pecl.php.net
RUN pecl install apcu
RUN docker-php-ext-enable apcu \
    && pecl clear-cache \
    RUN echo "extension=apcu.so" >> /usr/local/etc/php/php.ini
RUN echo "apc.enable_cli=1" >> /usr/local/etc/php/php.ini
RUN echo "apc.enable=1" >> /usr/local/etc/php/php.ini
RUN echo "apc.enable_cli=1" >> /usr/local/etc/php/conf.d/docker-php-ext-apcu.ini
RUN echo "apc.enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-apcu.ini
#APCU

#INSTALL XDEBUG
RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini
#XDEBUG

#INSTALL NVM & NPM & YARN
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.38.0/install.sh | bash
RUN export NVM_DIR="$([ -z "${XDG_CONFIG_HOME-}" ] && printf %s "${HOME}/.nvm" || printf %s "${XDG_CONFIG_HOME}/nvm")" \
    && [ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh" \
    && nvm install ${NODE_VERSION} \
    && npm install --global yarn
#NVM

#INSTALL Store Data Symfony
RUN docker-php-ext-install sysvmsg
RUN docker-php-ext-install sysvsem
RUN docker-php-ext-install sysvshm
#StoreData

#INSTALL REDIS
#RUN pecl install redis && docker-php-ext-enable redis #or add extension=redis.so in php.ini
#RUN echo "extension=redis.so" >> /usr/local/etc/php/php.ini
#REDIS

#
#INSTALL CRON
#RUN echo "* * * * * root /usr/local/bin/php /home/wwwroot/${DOCKER_DIR_PROJECT}/artisan schedule:run >> /var/log/cron.log 2>&1" >> /etc/crontab
# Create the log file to be able to run tail
#RUN touch /var/log/cron.log

#RUN rm -rf /var/lib/apt/lists/*
#RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
#    echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen && \
#   locale-gen

WORKDIR /home/wwwroot/${DOCKER_DIR_PROJECT}

#ADD . /var/www
#RUN chown -R www-data:www-data /var/www

EXPOSE 9000
#CMD bash -c "cron | php-fpm | /usr/bin/supervisord"
