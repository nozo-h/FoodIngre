FROM php:8.2.0-apache

# Dockerワークディレクトリを配置
WORKDIR /var/www/html

# PHP で必要なライブラリをインストール（Xdebugは一旦省略）
RUN apt-get update \ 
  && apt-get install -y \
  # GD用
  libonig-dev libzip-dev \
  unzip libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd \ 
#   && pecl install xdebug \
#   && docker-php-ext-enable xdebug \
  && docker-php-ext-install pdo_mysql mysqli mbstring zip bcmath

# mod_rewrite モジュールを使えるようにする
RUN a2enmod rewrite headers

# composer のインストール
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1

#ファイルをsrcから/var/www/html配下へコピーする（Xdebugは一旦省略）
RUN mkdir ./src
COPY ./src /var/www/html
COPY ./docker/php/php.development.ini /usr/local/etc/php/php.ini
# COPY ./docker/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
# COPY ./docker/php/000-default.conf /etc/apache2/sites-enabled/000-default.conf

# node.jsのインストール
# RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -
# RUN apt-get install -y nodejs

# 上記でエラーが出た場合
RUN apt-get update \
  && apt-get install -y ca-certificates curl gnupg \
  && mkdir -p /etc/apt/keyrings \
  && curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
  && NODE_MAJOR=20 \
  && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_MAJOR.x nodistro main" | tee /etc/apt/sources.list.d/nodesource.list \
  && apt-get update && apt-get install nodejs -y

RUN node --version
RUN npm --version