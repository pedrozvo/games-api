#!/bin/bash

# Crear archivo .env si no existe
if [ ! -f .env ]; then
    echo "Creando archivo .env desde .env.example..."
    cp .env.example .env
fi

# Generar clave de aplicación si no existe
if ! grep -q "APP_KEY=base64:" .env; then
    echo "Generando clave de aplicación..."
    php artisan key:generate --force
fi

# Crear base de datos SQLite si no existe
if [ ! -f database/database.sqlite ]; then
    echo "Creando base de datos SQLite..."
    touch database/database.sqlite
fi

# Ejecutar migraciones
echo "Ejecutando migraciones..."
php artisan migrate --force

# Optimizar aplicación para producción
echo "Optimizando aplicación..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ajustar permisos
echo "Ajustando permisos..."
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html/storage
chmod -R 755 /var/www/html/bootstrap/cache

echo "Iniciando servicios..."
# Iniciar supervisor
/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
