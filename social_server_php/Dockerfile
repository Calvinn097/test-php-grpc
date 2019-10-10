FROM registry.gitlab.com/pmberjaya/php-server

RUN apk add --no-cache \
		$PHPIZE_DEPS \
		openssl-dev

RUN pecl install grpc

RUN wget "https://github.com/protocolbuffers/protobuf/releases/download/v3.9.1/protoc-3.9.1-linux-x86_64.zip" -O "protoc-3.9.1-linux-x86_64.zip"
RUN unzip -p "protoc-3.9.1-linux-x86_64.zip" "bin/protoc" > "/usr/bin/protoc"

RUN apk --no-cache add ca-certificates wget
RUN wget -q -O /etc/apk/keys/sgerrand.rsa.pub https://alpine-pkgs.sgerrand.com/sgerrand.rsa.pub
RUN wget https://github.com/sgerrand/alpine-pkg-glibc/releases/download/2.30-r0/glibc-2.30-r0.apk
RUN apk add glibc-2.30-r0.apk

RUN pecl install protobuf

#Composer#
#COPY composer.lock composer.json /var/www/html/
COPY composer.json /var/www/html/
#WORKDIR /var/www/html
RUN git clone -b $(curl -L https://grpc.io/release) https://github.com/grpc/grpc
WORKDIR grpc
RUN git submodule update --init
RUN apk add --no-cache automake
RUN apk add --no-cache libtool
RUN make grpc_php_plugin

WORKDIR /var/www/html
RUN composer global require hirak/prestissimo
RUN composer install --no-scripts --no-autoloader

#End of Composer#

#Code Setting#
COPY ./docker/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/supervisord.conf /etc/supervisord.conf
COPY ./docker/php.ini /usr/local/etc/php
COPY . /var/www/html/
#RUN composer dump-autoload
RUN composer dump-autoload
RUN php artisan config:clear
#End Of Code Setting#

RUN cp .env.example .env

RUN chown -R www-data /var/www/html/storage

RUN chgrp -R www-data storage /var/www/html/storage
RUN chmod -R ug=r+w+x storage /var/www/html/storage

RUN chown -R www-data:www-data /tmp

RUN docker-php-ext-enable opencensus grpc.so protobuf.so


#cron job scheduler
COPY ./docker/laravel-cron /var/spool/cron/crontabs/root
RUN crond -L /var/www/html/cron.log
#end cron job

EXPOSE 80 443
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]