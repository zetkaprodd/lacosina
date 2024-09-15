FROM php:8.2-apache
RUN apt-get update && apt-get upgrade -y
RUN docker-lacosina-ext-install mysqli
EXPOSE 80