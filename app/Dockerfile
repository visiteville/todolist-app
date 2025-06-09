FROM php:8.2-apache

# Installer les dépendances
RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    unzip && \
    docker-php-ext-install \
    mysqli \
    pdo_mysql && \
    a2enmod rewrite

# Configurer Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

# Copier l'application
COPY . /var/www/html/

# Permissions
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Configuration PHP
RUN echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/errors.ini && \
    echo "display_errors = On" >> /usr/local/etc/php/conf.d/errors.ini

EXPOSE 80

