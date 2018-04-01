FROM richarvey/nginx-php-fpm
COPY . /var/www/html/
EXPOSE 80
