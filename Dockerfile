# Usamos una imagen base oficial de PHP 8.2 con Apache
FROM php:8.2-apache

# Instalar dependencias necesarias para PHP y herramientas
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip curl git \
    && docker-php-ext-install zip pdo pdo_mysql bcmath

# Habilitar módulos de Apache necesarios
RUN a2enmod rewrite

# Copiar el código de la aplicación al contenedor
COPY . /var/www/html

# Establecer permisos adecuados
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Configurar el VirtualHost para que Apache apunte a /public
RUN echo '<VirtualHost *:80>
    DocumentRoot /var/www/html/public

    <Directory /var/www/html/public>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalar dependencias PHP
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --working-dir=/var/www/html

# Asegurarse que el archivo JSON de Firebase esté en la ruta correcta
COPY storage/app/firebase/gestion-de-proyectos-271ca-firebase-adminsdk-fbsvc-08599b1cb5.json /var/www/html/storage/app/firebase/

# Exponer puerto
EXPOSE 80

# Comando para iniciar Apache
CMD ["apache2-foreground"]
