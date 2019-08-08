FROM php:7.3.3-apache

RUN apt-get update && apt-get install nano -y
RUN docker-php-ext-install mysqli

COPY ./html/index.php /var/www/html/
COPY ./html/style.css /var/www/html/
COPY ./php/php.ini /usr/local/etc/php/
COPY ./apache2/000-default.conf /etc/apache2/sites-available/000-default.conf

RUN apt install ssmtp -y
COPY ./ssmtp/ssmtp.conf /etc/ssmtp/ssmtp.conf
COPY ./ssmtp/revaliases.txt /etc/ssmtp/revaliases


RUN a2ensite 000-default.conf
RUN rm /usr/local/etc/php/php.ini-development && \
    rm /usr/local/etc/php/php.ini-production

EXPOSE 80

WORKDIR /var/www/html







