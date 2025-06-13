#!/usr/bin/env bash
set -o errexit

echo "Instalando dependencias PHP con Composer..."
composer install --no-interaction --prefer-dist --optimize-autoloader

echo "Compilando assets con Vite (si aplica)..."
npm install && npm run build || echo "No hay assets para compilar"
