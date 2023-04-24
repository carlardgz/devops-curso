#Aplicacion prueba
FROM php:5.3.29-apache
COPY . /var/www/html/
COPY ./000-default.conf /etc/apache2/sites-available/000-default.conf
RUN service apache2 restart
RUN docker-php-ext-install mysqli
EXPOSE 80

