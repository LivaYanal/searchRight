FROM php:8.3-fpm

# Systeempakketten en PHP-extensies die Laravel + MySQL nodig hebben
RUN apt-get update && apt-get install -y --no-install-recommends \
        git unzip libzip-dev libicu-dev \
    && docker-php-ext-install pdo_mysql zip intl bcmath \
    && rm -rf /var/lib/apt/lists/*

# Composer (PHP package manager)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Opstartscript (de sed haalt Windows-regeleinden weg, voor de zekerheid)
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN sed -i 's/\r$//' /usr/local/bin/entrypoint.sh && chmod +x /usr/local/bin/entrypoint.sh

# Alleen voor lokale ontwikkeling: PHP-FPM draait als root, net als artisan.
# Op Windows-mappen mag www-data anders geen bestandsdatums aanpassen
# ("touch(): Utime failed: Operation not permitted").
RUN sed -i 's/^user = www-data/user = root/; s/^group = www-data/group = root/' /usr/local/etc/php-fpm.d/www.conf

WORKDIR /var/www/html

ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm", "-R"]
