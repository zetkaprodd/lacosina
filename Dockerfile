FROM php:8.2-apache
RUN apt-get update && apt-get upgrade -y

RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN echo "extension=pdo_mysql" >> /usr/local/etc/php/php.ini
EXPOSE 80