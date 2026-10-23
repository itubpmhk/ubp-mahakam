# Website UBP Mahakam (Laravel) – one image: Apache + PHP 8.3, assets built inside.
# The server only needs Docker + Git; no PHP, Composer or Node on the host.

# ---------- 1. PHP dependencies ----------
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --no-scripts --no-autoloader --ignore-platform-reqs
COPY . .
RUN composer dump-autoload --no-dev --optimize --no-scripts

# ---------- 2. Front-end build (Vite + obfuscation) ----------
FROM node:22-slim AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci --no-audit --no-fund || (rm -rf node_modules && npm install --no-audit --no-fund)
COPY . .
RUN npm run build

# ---------- 3. Runtime ----------
FROM php:8.4-apache

RUN docker-php-ext-install pdo_mysql opcache \
 && a2enmod rewrite headers \
 && cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY docker/php.ini "$PHP_INI_DIR/conf.d/zz-app.ini"
COPY docker/vhost.conf /etc/apache2/sites-available/000-default.conf
RUN printf 'ServerTokens Prod\nServerSignature Off\nServerName localhost\n' > /etc/apache2/conf-enabled/zz-security.conf

WORKDIR /var/www/html
COPY --chown=www-data:www-data . .
COPY --chown=www-data:www-data --from=vendor /app/vendor ./vendor
COPY --chown=www-data:www-data --from=assets /app/public/build ./public/build

RUN rm -f public/hot public/storage \
 && php artisan package:discover --ansi \
 && chown -R www-data:www-data storage bootstrap/cache

COPY docker/entrypoint.sh /usr/local/bin/app-entrypoint
RUN sed -i 's/\r$//' /usr/local/bin/app-entrypoint && chmod +x /usr/local/bin/app-entrypoint

EXPOSE 80
ENTRYPOINT ["app-entrypoint"]
CMD ["apache2-foreground"]
