FROM shrikeh/php-apache:8.2
COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html