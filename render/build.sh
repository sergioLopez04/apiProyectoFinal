#!/usr/bin/env bash
set -o errexit

echo "Instalando PHP 8.2 y extensiones necesarias..."

apt-get update
apt-get install -y php8.2 php8.2-cli php8.2-mbstring php8.2-xml php8.2-curl php8.2-mysql php8.2-bcmath php8.2-zip unzip

echo "Instalando Composer..."
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

composer install --no-interaction --prefer-dist --optimize-autoloader
