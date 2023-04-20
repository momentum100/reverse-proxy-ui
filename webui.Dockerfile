FROM php:8.0-fpm

RUN apt-get update && apt-get install -y \
    libsqlite3-dev sudo sqlite3 certbot && \
    docker-php-ext-install pdo_sqlite && \
    rm -rf /var/lib/apt/lists/*

ENV DOCKERVERSION=19.03.12
RUN curl -fsSLO https://download.docker.com/linux/static/stable/x86_64/docker-${DOCKERVERSION}.tgz \
  && tar xzvf docker-${DOCKERVERSION}.tgz --strip 1 -C /usr/local/bin docker/docker \
  && rm docker-${DOCKERVERSION}.tgz

RUN usermod -aG sudo www-data
RUN echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers

COPY ./src/nginx-templates /nginx-templates
