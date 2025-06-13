# Usamos una imagen base oficial de PHP 8.2 con Apache
FROM php:8.2-apache

# Instalar dependencias necesarias para PHP y herramientas
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip curl git \
    && docker-php-ext-install zip pdo pdo_mysql bcmath

# Habilitar módulos de Apache necesarios
RUN a2enmod rewrite

# Copiar el archivo de configuración personalizado de Apache
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Copiar el código de la aplicación al contenedor
COPY . /var/www/html

# Copiar el archivo de configuración de Firebase (ajusta si está en .gitignore)
COPY storage/app/firebase/gestion-de-proyectos-271ca-firebase-adminsdk-fbsvc-08599b1cb5.json /var/www/html/storage/app/firebase/

# Establecer permisos apropiados
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar dependencias de PHP con Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --working-dir=/var/www/html

# Exponer el puerto 80
EXPOSE 80

# Arrancar Apache en primer plano
CMD ["apache2-foreground"]
