FROM php:8.2-apache

# 1. Instalar dependencias del sistema y PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    nodejs \
    npm

# 2. Instalar extensiones de PHP necesarias para Laravel y PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql pgsql gd zip

# 3. Habilitar mod_rewrite de Apache (necesario para las rutas de Laravel)
RUN a2enmod rewrite

# 4. Cambiar el Document Root de Apache a la carpeta "public" de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 5. Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 6. Copiar los archivos del proyecto al contenedor
WORKDIR /var/www/html
COPY . .

# 7. Instalar dependencias de PHP y Node.js (Vite)
RUN composer install --no-dev --optimize-autoloader
RUN npm install
RUN npm run build

# 8. Dar permisos a las carpetas de almacenamiento
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 9. Exponer el puerto 80
EXPOSE 80

# 10. Iniciar Apache en primer plano
CMD ["apache2-foreground"]
