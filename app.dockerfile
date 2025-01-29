FROM php:7.4-fpm-bullseye

RUN apt-get update && apt-get install -y libmcrypt-dev zlib1g-dev libicu-dev g++ \
    default-mysql-client libmagickwand-dev git zip unzip curl --no-install-recommends \
    && pecl install imagick \
    && pecl install mcrypt-1.0.4 
RUN apt install libonig-dev
RUN docker-php-ext-enable imagick mcrypt
RUN docker-php-ext-install mysqli 
RUN docker-php-ext-install pdo_mysql intl mbstring
RUN docker-php-ext-configure intl 

RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -

# CMD ["npm", "run", "watch-poll"]