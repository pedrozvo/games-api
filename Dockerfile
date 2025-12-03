# 1. Usamos una imagen oficial de PHP con Apache
FROM php:8.2-apache

# 2. Instalar dependencias del sistema necesarias para Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git

# 3. Limpiar caché para reducir el tamaño de la imagen
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# 4. Instalar extensiones de PHP requeridas (PDO para MySQL, etc.)
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# 5. Habilitar el módulo rewrite de Apache (Vital para las rutas de Laravel)
RUN a2enmod rewrite

# 6. Configurar el DocumentRoot de Apache a la carpeta /public de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 7. Instalar Composer (el gestor de paquetes) dentro del contenedor
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 8. Establecer el directorio de trabajo
WORKDIR /var/www/html

# 9. Copiar los archivos del proyecto al contenedor
COPY . .

# 10. Instalar dependencias de Laravel (Optimizadas para producción)
RUN composer install --no-interaction --optimize-autoloader --no-dev

# 11. Ajustar permisos (Apache necesita ser dueño de los archivos)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 12. Exponer el puerto 80
EXPOSE 80

# 13. Comando por defecto al iniciar el contenedor
CMD ["apache2-foreground"]