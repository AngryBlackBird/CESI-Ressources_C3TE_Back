FROM phpmyadmin/phpmyadmin


RUN mkdir /ssl-certs
RUN openssl req -new -newkey rsa:2048 -days 365 -nodes -x509 -subj \
    "/C=../ST=../L=..../O=LAB/CN=....." \
    -keyout /ssl-certs/ssl.key -out /ssl-certs/ssl.crt

RUN a2enmod ssl

RUN sed -ri -e 's,80,443,' /etc/apache2/sites-available/000-default.conf
RUN sed -i -e '/^<\/VirtualHost>/i SSLEngine on' /etc/apache2/sites-available/000-default.conf
RUN sed -i -e '/^<\/VirtualHost>/i SSLCertificateFile /ssl-certs/ssl.crt' /etc/apache2/sites-available/000-default.conf
RUN sed -i -e '/^<\/VirtualHost>/i SSLCertificateKeyFile /ssl-certs/ssl.key' /etc/apache2/sites-available/000-default.conf


EXPOSE 80 443