FROM richarvey/nginx-php-fpm:3.1.6

COPY . .

# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# ENV DB_CONNECTION mysql
# ENV DB_HOST mysql-148320-0.cloudclusters.net
# ENV DB_PORT 19999
# ENV DB_DATABASE school_verse
# ENV DB_USERNAME admin
# ENV DB_PASSWORD oVbJRDxv

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

CMD ["/start.sh"]
