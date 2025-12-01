FROM php:8.2-fpm

# Argumentos
ARG user=laravel
ARG uid=1000

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Limpiar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones de PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Obtener Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crear usuario del sistema para ejecutar Composer y Artisan
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Establecer directorio de trabajo
WORKDIR /var/www

# Copiar archivos de dependencias
COPY composer.json composer.lock package.json package-lock.json* ./

# Instalar dependencias de PHP
RUN composer install --no-scripts --no-autoloader --prefer-dist

# Instalar dependencias de Node
RUN npm install

# Copiar el resto de la aplicación
COPY . .

# Completar la instalación de Composer
RUN composer dump-autoload --optimize

# Compilar assets
RUN npm run build

# Establecer permisos
RUN chown -R $user:www-data /var/www
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Cambiar al usuario creado
USER $user

# Exponer puerto 9000 para PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]

