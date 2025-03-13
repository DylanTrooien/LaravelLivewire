FROM alpine:latest

RUN apk update
RUN apk upgrade
RUN apk add bash
RUN apk add curl
RUN apk add nginx
RUN apk add php83
RUN apk add php83-gd
RUN apk add php83-fpm
RUN apk add php83-pdo
RUN apk add php83-xml
RUN apk add php83-dom
RUN apk add php83-zlib
RUN apk add php83-curl
RUN apk add php83-session
RUN apk add php83-opcache
RUN apk add php83-sqlite3
RUN apk add php83-fileinfo
RUN apk add php83-mbstring
RUN apk add php83-xmlwriter
RUN apk add php83-tokenizer
RUN apk add php83-pdo_sqlite
RUN apk add composer
RUN apk add sqlite
RUN apk add nodejs
RUN apk add npm

# Install Composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && EXPECTED_SIGNATURE="$(wget -q -O - https://composer.github.io/installer.sig)" \
    && ACTUAL_SIGNATURE="$(php -r "echo hash_file('sha384', 'composer-setup.php');")" \
    && if [ "$EXPECTED_SIGNATURE" != "$ACTUAL_SIGNATURE" ]; then \
        echo 'ERROR: Invalid installer signature' >&2; \
        rm composer-setup.php; \
        exit 1; \
    fi \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

COPY php /etc/php83
COPY nginx /etc/nginx
COPY html /usr/share/nginx/html

RUN mkdir /var/run/php

EXPOSE 80

STOPSIGNAL SIGTERM

CMD ["/bin/bash", "-c", "php-fpm83 && chmod 777 /var/run/php/php8-fpm.sock && chmod -R 755 /usr/share/nginx/html/* && nginx -g 'daemon off;'"]