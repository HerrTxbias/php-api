FROM richarvey/nginx-php-fpm
COPY src/ /var/www/html/
WORKDIR /root/
EXPOSE 80
CMD "npm start"