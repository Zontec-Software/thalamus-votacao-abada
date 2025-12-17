FROM php:8.2-apache

# Diretório de trabalho
WORKDIR /var/www/html/

# Copia o projeto
COPY . /var/www/html/

# Usuário root para instalar pacotes e ajustar permissões
USER root

# Instale certificados SSL
RUN apt-get install -y ca-certificates

# Permissões
RUN chown -R www-data:www-data /var/www/html/

# Configs do Apache e PHP
COPY ./docker/apache2/ /etc/apache2/
COPY ./docker/php/conf.d/ /usr/local/etc/php/conf.d/

# Instala dependências e extensões PHP
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    zip \
    openssl \
    unzip \
    git \
    supervisor \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j"$(nproc)" \
    pdo_mysql \
    gd \
    zip \
    sockets \
    bcmath \
 && rm -rf /var/lib/apt/lists/*

#RUN apt-get install -y mysql-client

# OpCache otimizado
# COPY ./docker/php/conf.d/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

COPY ./docker/ssl/certs /etc/ssl/certs

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# mod_rewrite
RUN a2enmod rewrite

USER www-data

# Dependências do Laravel (sem dev para produção)
RUN composer install --no-interaction


USER root

# Supervisor: cria diretórios de runtime e log
RUN mkdir -p /var/log/supervisor /var/run \
 && chown -R www-data:www-data /var/log/supervisor

# Copia a configuração do Supervisor
COPY ./docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Porta HTTP
EXPOSE 80

# Inicia o Supervisor (que inicia Apache + queue worker)
CMD ["/usr/bin/supervisord"]
