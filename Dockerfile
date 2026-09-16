FROM php:7.4-fpm-alpine

# 1. Install dependensi sistem termasuk libzip-dev
RUN apk update && apk add --no-cache \
    nginx \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    oniguruma-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# 2. Konfigurasi Nginx
COPY <<EOF /etc/nginx/http.d/default.conf
server {
    listen 80;
    root /var/www/html/public;
    index index.php index.html;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        include fastcgi_params;
    }
}
EOF

WORKDIR /var/www/html
COPY . .

# 3. Install Composer 2.2 LTS
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 4. Set permission direktori Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 80

# 5. Jalankan PHP-FPM dan Nginx
CMD php-fpm -D && nginx -g "daemon off;"