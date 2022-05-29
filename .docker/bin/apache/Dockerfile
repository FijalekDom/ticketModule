FROM php:8.1.0-apache

RUN apt -y update --fix-missing
RUN apt -y install nano mc wget htop zip git iputils-ping

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo_mysql mysqli \
    && apt -y install libzip-dev \
    && docker-php-ext-install zip \
    && apt -y install libicu-dev \
    && docker-php-ext-install -j$(nproc) intl

RUN apt -y autoremove

RUN a2enmod rewrite headers

ARG developer_name
ARG developer_uid
RUN useradd -m ${developer_name} -s /bin/bash -u ${developer_uid}