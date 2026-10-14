FROM php:8.4-apache
RUN apt-get update && apt-get install -y git unzip libzip-dev nodejs npm \
 && docker-php-ext-install pdo_mysql zip \
 && a2enmod rewrite \
 && sed -i 's#/var/www/html#/var/www/html/public#' /etc/apache2/sites-available/000-default.conf
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]
CMD ["apache2-foreground"]
