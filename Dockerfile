# Usamos la imagen oficial de PHP 8.2 con Apache
FROM php:8.2-apache

# Instalar dependencias del sistema y extensiones PHP necesarias para Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure zip \
    && docker-php-ext-install pdo pdo_mysql mbstring zip xml gd bcmath

# Habilitar mod_rewrite para Apache (importante para Laravel)
RUN a2enmod rewrite

# Instalar Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar el código fuente al directorio por defecto de Apache
COPY . /var/www/html

# Cambiar permisos para que Apache pueda escribir en storage y bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Ejecutar composer install para instalar dependencias (puedes cambiar parámetros si quieres)
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Exponer el puerto 80 para el servidor Apache
EXPOSE 80

# Comando por defecto para iniciar Apache en primer plano
CMD ["apache2-foreground"]
