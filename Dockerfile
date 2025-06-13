# Usamos una imagen oficial de PHP con Apache y extensiones necesarias
FROM php:8.1-apache

# Instalar dependencias del sistema y extensiones PHP necesarias para Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git curl libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql zip mbstring exif pcntl bcmath gd

# Activar mod_rewrite de Apache (importante para Laravel)
RUN a2enmod rewrite

# Instalar Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar código al directorio de Apache
COPY . /var/www/html

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Cambiar permisos para que Apache pueda escribir en storage y bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Instalar dependencias de PHP con composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Exponer puerto 80
EXPOSE 80

# Comando por defecto para iniciar Apache en primer plano
CMD ["apache2-foreground"]
