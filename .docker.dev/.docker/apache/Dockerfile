ARG DEBIAN_VERSION

FROM debian:${DEBIAN_VERSION}

ARG DOCKER_DNS

ENV HTTPD_PREFIX /usr/local/apache2
ENV PATH $HTTPD_PREFIX/bin:$PATH
RUN mkdir -p "$HTTPD_PREFIX" \
    && chown www-data:www-data "$HTTPD_PREFIX"
WORKDIR $HTTPD_PREFIX

RUN apt-get update \
    && apt-get install -y --no-install-recommends debianutils \
    apache2 curl unzip openssl \
    && rm -r /var/lib/apt/lists/*
RUN mkdir /ssl-certs
RUN openssl req -new -newkey rsa:2048 -days 365 -nodes -x509 -subj \
    "/C=../ST=../L=..../O=LAB/CN=....." \
    -keyout /ssl-certs/ssl.key -out /ssl-certs/ssl.crt
RUN mkdir /etc/apache2/ssl
RUN cp /ssl-certs/ssl.key /etc/apache2/ssl/ssl.key \
 && cp /ssl-certs/ssl.crt /etc/apache2/ssl/ssl.crt
RUN a2enmod proxy_fcgi ssl rewrite proxy proxy_balancer proxy_http proxy_ajp headers
RUN sed -i '/Global configuration/a \ServerName $DOCKER_DNS \' /etc/apache2/apache2.conf

EXPOSE 80 443
RUN rm -f /run/apache2/apache2.pid
CMD apachectl -DFOREGROUND -e info
