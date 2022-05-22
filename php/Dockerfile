FROM wordpress:5.8-php7.4-fpm

RUN apt-get update && apt-get install -y libxml2-dev
RUN docker-php-ext-install soap
