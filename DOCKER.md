# 🐳 Guía Rápida de Docker - Games API

## Inicio Rápido

### 1. Preparar el entorno

```bash
# Copiar variables de entorno
cp .env.example .env
```

### 2. Configurar .env para Docker

Asegúrate de que estas variables estén configuradas en tu archivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=games_db
DB_USERNAME=laravel
DB_PASSWORD=secret
```

### 3. Levantar los contenedores

```bash
# Construir y levantar todos los servicios
docker-compose up -d --build
```

### 4. Configurar Laravel

```bash
# Generar clave de aplicación
docker-compose exec app php artisan key:generate

# Ejecutar migraciones
docker-compose exec app php artisan migrate
```

### 5. ¡Listo! 🎉

- **API**: http://localhost:8000/api/games
- **phpMyAdmin**: http://localhost:8080

---

## Comandos Frecuentes

### Ver logs
```bash
# Ver logs en tiempo real
docker-compose logs -f

# Ver logs solo de la aplicación
docker-compose logs -f app

# Ver logs de nginx
docker-compose logs -f nginx

# Ver logs de la base de datos
docker-compose logs -f db
```

### Ejecutar comandos Artisan
```bash
# Crear una migración
docker-compose exec app php artisan make:migration nombre_migracion

# Ejecutar migraciones
docker-compose exec app php artisan migrate

# Rollback de migraciones
docker-compose exec app php artisan migrate:rollback

# Crear un controlador
docker-compose exec app php artisan make:controller NombreController

# Crear un modelo
docker-compose exec app php artisan make:model NombreModelo

# Limpiar caché
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
```

### Ejecutar tests
```bash
docker-compose exec app php artisan test

# Con cobertura
docker-compose exec app php artisan test --coverage
```

### Composer
```bash
# Instalar un paquete
docker-compose exec app composer require paquete/nombre

# Actualizar dependencias
docker-compose exec app composer update

# Dump autoload
docker-compose exec app composer dump-autoload
```

### Acceder al contenedor
```bash
# Acceder al bash del contenedor de la aplicación
docker-compose exec app bash

# Acceder al contenedor de base de datos
docker-compose exec db bash

# Acceder a MySQL desde el contenedor
docker-compose exec db mysql -u laravel -psecret games_db
```

### Gestionar contenedores
```bash
# Ver estado de los contenedores
docker-compose ps

# Detener los contenedores
docker-compose stop

# Iniciar los contenedores detenidos
docker-compose start

# Reiniciar un servicio específico
docker-compose restart app

# Reconstruir un servicio
docker-compose up -d --build app

# Detener y eliminar contenedores
docker-compose down

# Eliminar contenedores y volúmenes (¡CUIDADO! Borra la BD)
docker-compose down -v
```

### Ver recursos utilizados
```bash
# Ver uso de recursos de los contenedores
docker stats

# Ver imágenes
docker images

# Ver volúmenes
docker volume ls
```

---

## Solución de Problemas

### El puerto 8000 ya está en uso

```bash
# Opción 1: Cambiar el puerto en docker-compose.yml
# Modifica la línea: - "8001:80" (usar puerto 8001 en lugar de 8000)

# Opción 2: Detener el proceso que usa el puerto 8000
netstat -ano | findstr :8000
taskkill /PID <número_del_pid> /F
```

### Error de permisos en storage/logs

```bash
# Dar permisos desde dentro del contenedor
docker-compose exec app chmod -R 775 storage bootstrap/cache
docker-compose exec app chown -R laravel:www-data storage bootstrap/cache
```

### Base de datos no se conecta

```bash
# Verificar que el contenedor de base de datos esté corriendo
docker-compose ps

# Ver logs de la base de datos
docker-compose logs db

# Asegúrate de que DB_HOST=db en el archivo .env
```

### Reconstruir todo desde cero

```bash
# Detener y eliminar todo
docker-compose down -v

# Limpiar imágenes
docker system prune -a

# Reconstruir
docker-compose up -d --build

# Reconfigurar Laravel
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
```

### Ver variables de entorno dentro del contenedor

```bash
docker-compose exec app env
```

---

## Estructura de Servicios

| Servicio | Puerto Host | Puerto Container | Descripción |
|----------|-------------|------------------|-------------|
| nginx | 8000 | 80 | Servidor web |
| app | - | 9000 | PHP-FPM (Laravel) |
| db | 3306 | 3306 | MySQL |
| phpmyadmin | 8080 | 80 | Administrador de BD |

---

## Archivos de Configuración Docker

```
games-api/
├── Dockerfile              # Imagen de la aplicación Laravel
├── docker-compose.yml      # Orquestación de servicios
├── .dockerignore          # Archivos excluidos de la imagen
└── docker/
    └── nginx/
        └── default.conf   # Configuración de Nginx
```

---

## Producción

Para producción, considera:

1. Usar imágenes optimizadas
2. Configurar variables de entorno seguras
3. Usar secrets de Docker
4. Implementar SSL/TLS
5. Configurar backups de la base de datos
6. Usar volúmenes nombrados para persistencia

```bash
# Ejemplo para producción
docker-compose -f docker-compose.prod.yml up -d
```

