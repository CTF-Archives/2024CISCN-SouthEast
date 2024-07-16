FROM php:7.4.28-apache

COPY html /tmp/html
COPY flag /tmp
COPY myphp.so /tmp
COPY php.ini /tmp
COPY 000-default.conf /tmp

RUN sed -i 's/deb.debian.org/mirrors.ustc.edu.cn/g' /etc/apt/sources.list &&\
    apt-get update &&\
    mv /tmp/html/* /var/www/html &&\
    mv /tmp/flag /flag &&\
    mv /tmp/myphp.so /home/myphp.so &&\
    mv /tmp/php.ini /usr/local/etc/php/php.ini &&\
    mv /tmp/000-default.conf /etc/apache2/sites-available/000-default.conf &&\
    rm -rf /tmp/* &&\
    chown -R root:root /var/www/html &&\
    chmod -R 755 /var/www/html &&\
    chown root:root /flag &&\
    chmod 444 /flag