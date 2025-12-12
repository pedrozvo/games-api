# 🚀 Deploy Rápido con Docker

## ✅ Pre-requisitos

- Docker Desktop instalado y corriendo
- Git instalado

## 🎯 Deploy en 3 Pasos

### 1️⃣ Clonar el repositorio

```bash
git clone https://github.com/pedrozvo/games-api.git
cd games-api
```

### 2️⃣ Levantar con Docker Compose

```bash
docker-compose up -d
```

### 3️⃣ ¡Listo! 🎉

- **API:** http://localhost:8080/api/games
- **phpMyAdmin:** http://localhost:8081
  - Usuario: `root`
  - Password: `secret`

## 🧪 Verificar que funciona

### Crear un juego

```bash
curl -X POST http://localhost:8080/api/games \
  -H "Content-Type: application/json" \
  -d '{
    "title": "The Legend of Zelda",
    "description": "Epic adventure game",
    "genre": "Adventure",
    "platform": "Nintendo Switch"
  }'
```

### Listar juegos

```bash
curl http://localhost:8080/api/games
```

O simplemente abre en el navegador:
- http://localhost:8080/api/games

## 📊 Ver logs

```bash
# Logs en tiempo real
docker-compose logs -f app

# Logs de todos los servicios
docker-compose logs -f
```

## 🛑 Detener

```bash
docker-compose down
```

## 🔄 Actualizar

```bash
# Pull de cambios
git pull origin main

# Rebuild y restart
docker-compose down
docker-compose up --build -d
```

## 🔧 Comandos útiles dentro del contenedor

```bash
# Ejecutar migraciones
docker-compose exec app php artisan migrate

# Ejecutar tests
docker-compose exec app php artisan test

# Crear datos de prueba
docker-compose exec app php artisan tinker
>>> App\Models\Game::factory(10)->create()

# Ver rutas
docker-compose exec app php artisan route:list
```

## 🌍 Deploy en Servidor

### Opción 1: VPS con Docker

```bash
# En el servidor (Linux)
git clone https://github.com/pedrozvo/games-api.git
cd games-api

# Configurar .env para producción
cp .env.example .env
nano .env

# Levantar servicios
docker-compose up -d

# Ejecutar migraciones
docker-compose exec app php artisan migrate --force
```

### Opción 2: Con Docker Hub

```bash
# Local: Build y push
docker build -t TU_USUARIO/games-api:latest .
docker push TU_USUARIO/games-api:latest

# Servidor: Pull y run
docker pull TU_USUARIO/games-api:latest
docker run -d -p 80:80 TU_USUARIO/games-api:latest
```

## 🔐 Producción

Para producción, recuerda cambiar en `.env`:

```env
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:... # Generar nueva

DB_CONNECTION=mysql
DB_HOST=mysql
DB_DATABASE=games_api
DB_USERNAME=games_user
DB_PASSWORD=TU_PASSWORD_SEGURO_AQUI

MYSQL_ROOT_PASSWORD=TU_PASSWORD_ROOT_SEGURO
```

## 🐛 Troubleshooting

### Puerto 8080 en uso

Cambia el puerto en `docker-compose.yml`:
```yaml
ports:
  - "8081:80"  # Usa otro puerto
```

### Permisos en Linux

```bash
sudo chown -R $USER:$USER .
docker-compose up -d
```

### Base de datos no funciona

```bash
docker-compose down -v
docker-compose up -d
docker-compose exec app php artisan migrate:fresh --force
```

## ✅ Checklist de Deploy

- [ ] Clonar repositorio
- [ ] Docker Desktop corriendo
- [ ] `docker-compose up -d`
- [ ] Verificar logs sin errores
- [ ] Probar endpoints en Postman
- [ ] Verificar conexión a base de datos
- [ ] Configurar variables de entorno para producción
- [ ] Cambiar contraseñas por defecto

---

**¡Tu API está deployada y lista para usar!** 🎉

**Documentación completa:** Ver [DOCKER.md](DOCKER.md)
