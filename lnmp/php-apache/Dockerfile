######
# See: https://hub.docker.com/_/php/
######

FROM daocloud.io/php:7.0-apache

MAINTAINER KevinZ <kevin8093@126.com>

######
# You can install php extensions using docker-php-ext-install
######
 
#RUN apt-get update && apt-get install -y \
#        libfreetype6-dev \
#        libjpeg62-turbo-dev \
#        libmcrypt-dev \
#        libpng12-dev \
#    && docker-php-ext-install -j$(nproc) iconv mcrypt \
#    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
#    && docker-php-ext-install -j$(nproc) gd \
RUN docker-php-ext-install pdo_mysql

COPY 000-default.conf /etc/apache2/sites-enabled/
COPY apache2.conf     /etc/apache2/
COPY ports.conf       /etc/apache2/
COPY php.ini          /usr/local/etc/php/
