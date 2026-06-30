FROM php:8.2-apache

# Cài đặt extension MySQL cho PHP
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Mở module rewrite của Apache (nếu API có dùng .htaccess)
RUN a2enmod rewrite

# Copy toàn bộ source code vào thư mục web của Apache
COPY . /var/www/html/

# Cấp quyền đọc ghi cho thư mục uploads (nếu có)
RUN chown -R www-data:www-data /var/www/html/