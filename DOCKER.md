# 🐳 Guía de Docker - Games API

## 📦 Contenido

Esta guía te mostrará cómo deployar la API usando Docker y Docker Compose.

## 🛠️ Requisitos Previos

- **Docker Desktop** instalado
  - Windows: https://docs.docker.com/desktop/install/windows-install/
  - Mac: https://docs.docker.com/desktop/install/mac-install/
  - Linux: https://docs.docker.com/desktop/install/linux-install/
- **Docker Compose** (incluido en Docker Desktop)

## 🚀 Inicio Rápido

### Opción 1: Con el Dockerfile existente (Apache)

```bash
# 1. Construir la imagen
docker build -t games-api .

# 2. Ejecutar el contenedor
docker run -p 8080:80 --name games-api-container games-api

# 3. Acceder a la API
# http://localhost:8080/api/games
```

### Opción 2: Con Docker Compose (Recomendado)

```bash
# 1. Levantar todos los servicios
docker-compose up -d

# 2. Ver logs
docker-compose logs -f

# 3. Acceder a la API
# API: http://localhost:8080/api/games
# phpMyAdmin: http://localhost:8081
```

## 📋 Servicios Disponibles

| Servicio | Puerto | URL | Descripción |
|----------|--------|-----|-------------|
| API (Apache) | 8080 | http://localhost:8080 | API Laravel |
| MySQL | 3306 | localhost:3306 | Base de datos |
| phpMyAdmin | 8081 | http://localhost:8081 | Administrador BD |

## 🔧 Comandos Útiles

### Gestión de Contenedores

```bash
# Levantar servicios
docker-compose up -d

# Detener servicios
docker-compose down

# Ver logs en tiempo real
docker-compose logs -f app

# Ver estado de contenedores
docker-compose ps

# Reiniciar servicios
docker-compose restart

# Eliminar todo (incluyendo volúmenes)
docker-compose down -v
```

### Ejecutar Comandos Dentro del Contenedor

```bash
# Acceder al contenedor
docker-compose exec app bash

# Ejecutar migraciones
docker-compose exec app php artisan migrate

# Ejecutar tests
docker-compose exec app php artisan test

# Limpiar caché
docker-compose exec app php artisan cache:clear

# Generar datos de prueba
docker-compose exec app php artisan tinker
>>> App\Models\Game::factory(10)->create()
```

### Gestión de Base de Datos

```bash
# Ejecutar migraciones
docker-compose exec app php artisan migrate:fresh

# Ejecutar seeders
docker-compose exec app php artisan db:seed

# Acceder a MySQL
docker-compose exec mysql mysql -u games_user -p games_api
# Password: games_password
```

## 🔄 Configuración del .env para Docker

Si usas MySQL en lugar de SQLite, actualiza tu `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=games_api
DB_USERNAME=games_user
DB_PASSWORD=games_password
```

## 📊 Arquitectura Docker Compose

```
┌─────────────────────────────────────────────┐
│          Docker Compose Network             │
│                                             │
│  ┌──────────────┐      ┌────────────────┐ │
│  │   App (API)  │─────→│     MySQL      │ │
│  │   Port 8080  │      │   Port 3306    │ │
│  └──────────────┘      └────────────────┘ │
│         │                      │           │
│         │              ┌───────▼────────┐  │
│         │              │  phpMyAdmin    │  │
│         │              │   Port 8081    │  │
│         │              └────────────────┘  │
└─────────────────────────────────────────────┘
```

## 🏗️ Build y Deploy

### Desarrollo Local

```bash
# Build y levantar
docker-compose up --build -d

# Ver logs
docker-compose logs -f app
```

### Producción

```bash
# Build optimizado
docker build -t games-api:production \
  --target production \
  --build-arg APP_ENV=production .

# Ejecutar en producción
docker run -d \
  -p 80:80 \
  --name games-api-prod \
  -e APP_ENV=production \
  -e APP_DEBUG=false \
  games-api:production
```

## 🔍 Troubleshooting

### Error: "Port already in use"

```bash
# Ver qué está usando el puerto
netstat -ano | findstr :8080

# Cambiar el puerto en docker-compose.yml
ports:
  - "8081:80"  # Cambiar 8080 por otro puerto
```

### Error: "Permission denied"

```bash
# Dentro del contenedor, arreglar permisos
docker-compose exec app chown -R www-data:www-data /var/www/html
docker-compose exec app chmod -R 755 /var/www/html/storage
```

### Error: "SQLSTATE[HY000] [2002] Connection refused"

```bash
# Verificar que MySQL esté corriendo
docker-compose ps

# Reiniciar MySQL
docker-compose restart mysql

# Ver logs de MySQL
docker-compose logs mysql
```

### La base de datos no se crea

```bash
# Ejecutar migraciones manualmente
docker-compose exec app php artisan migrate:fresh --force
```

## 📦 Volúmenes de Datos

Los datos se persisten en volúmenes Docker:

```bash
# Ver volúmenes
docker volume ls

# Inspeccionar volumen
docker volume inspect games-api_mysql_data

# Hacer backup del volumen MySQL
docker run --rm \
  -v games-api_mysql_data:/data \
  -v $(pwd):/backup \
  ubuntu tar czf /backup/mysql-backup.tar.gz /data
```

## 🔐 Variables de Entorno

Puedes personalizar las variables en `docker-compose.yml`:

```yaml
environment:
  - APP_ENV=production
  - APP_DEBUG=false
  - APP_KEY=base64:...
  - DB_CONNECTION=mysql
  - DB_HOST=mysql
  - DB_DATABASE=games_api
  - DB_USERNAME=games_user
  - DB_PASSWORD=CAMBIAR_PASSWORD_SEGURO
```

## 🧪 Testing en Docker

```bash
# Ejecutar todos los tests
docker-compose exec app php artisan test

# Tests con coverage
docker-compose exec app php artisan test --coverage

# Tests específicos
docker-compose exec app php artisan test --filter GameTest
```

## 🚢 Deploy en Producción

### Docker Hub

```bash
# Login en Docker Hub
docker login

# Tag de la imagen
docker tag games-api:latest TU_USUARIO/games-api:latest

# Push a Docker Hub
docker push TU_USUARIO/games-api:latest

# Pull en servidor
docker pull TU_USUARIO/games-api:latest
docker run -d -p 80:80 TU_USUARIO/games-api:latest
```

### Con Docker Compose en Servidor

```bash
# En el servidor
git clone https://github.com/TU_USUARIO/games-api.git
cd games-api

# Configurar .env para producción
cp .env.example .env
nano .env

# Levantar servicios
docker-compose up -d

# Ejecutar migraciones
docker-compose exec app php artisan migrate --force
```

## 🔄 Actualizar la Aplicación

```bash
# Pull de cambios
git pull origin main

# Rebuild y restart
docker-compose down
docker-compose up --build -d

# Ejecutar migraciones
docker-compose exec app php artisan migrate --force

# Limpiar caché
docker-compose exec app php artisan optimize:clear
```

## 📝 Checklist de Deploy

- [ ] Configurar `.env` para producción
- [ ] Cambiar `APP_DEBUG=false`
- [ ] Generar `APP_KEY`
- [ ] Configurar base de datos
- [ ] Cambiar contraseñas por defecto
- [ ] Ejecutar migraciones
- [ ] Configurar CORS si es necesario
- [ ] Configurar SSL/HTTPS (con nginx-proxy)
- [ ] Configurar backups automáticos
- [ ] Monitoreo y logs

## 🌐 HTTPS con Let's Encrypt (Opcional)

Si quieres agregar HTTPS en producción:

```yaml
# Agregar a docker-compose.yml
  nginx-proxy:
    image: nginxproxy/nginx-proxy
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - /var/run/docker.sock:/tmp/docker.sock:ro
      - certs:/etc/nginx/certs

  letsencrypt:
    image: nginxproxy/acme-companion
    volumes:
      - /var/run/docker.sock:/var/run/docker.sock:ro
      - certs:/etc/nginx/certs
```

## 🎯 Recursos Adicionales

- **Documentación Docker**: https://docs.docker.com/
- **Docker Compose**: https://docs.docker.com/compose/
- **Laravel Sail**: https://laravel.com/docs/sail (alternativa oficial de Laravel)

---

**¡Tu API ahora está lista para ser deployada con Docker!** 🐳🚀
