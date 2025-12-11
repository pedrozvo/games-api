# ⚡ Inicio Rápido - Games API

## 🚀 Para Desarrolladores

### Opción 1: Con Docker (Más Rápido) 🐳

```bash
# Levantar todos los servicios
docker-compose up -d

# Ver logs
docker-compose logs -f app

# Acceder a la API
# http://localhost:8080/api/games

# phpMyAdmin
# http://localhost:8081
```

### Opción 2: Con Laragon (Windows)

```bash
# 1. Abre la terminal de Laragon (Cmder)
# 2. Navega al proyecto
cd j:\transformacion\games-api

# 3. Levanta el servidor
php artisan serve
```

### Opción 3: PowerShell Normal

```powershell
# 1. Agregar PHP al PATH (temporal)
$env:Path += ";C:\laragon\bin\php\php-8.3.28-Win32-vs16-x64"

# 2. Ir al proyecto
cd j:\transformacion\games-api

# 3. Levantar servidor
php artisan serve
```

## 🧪 Ejecutar Tests

### Con Docker
```bash
docker-compose exec app php artisan test
```

### Local
```bash
php artisan test
```

## 📮 Probar en Postman

1. Importa: `Games-API.postman_collection.json`
2. Variable `base_url`: `http://127.0.0.1:8000`
3. ¡Listo para usar!

## 🔄 Comandos Útiles

### Docker
```bash
# Levantar servicios
docker-compose up -d

# Detener servicios
docker-compose down

# Ver logs
docker-compose logs -f app

# Ejecutar comandos dentro del contenedor
docker-compose exec app php artisan migrate
docker-compose exec app php artisan tinker
```

### Local
```bash
# Ver rutas
php artisan route:list

# Limpiar caché
php artisan cache:clear

# Re-ejecutar migraciones
php artisan migrate:fresh

# Generar datos de prueba
php artisan tinker
>>> App\Models\Game::factory(10)->create()

# Ver logs en tiempo real
php artisan pail

# Verificar estilo de código
./vendor/bin/pint
```

## 📝 Primera Petición

```bash
# Crear un juego
curl -X POST http://127.0.0.1:8000/api/games \
  -H "Content-Type: application/json" \
  -d '{"title":"Zelda","description":"Aventura épica","genre":"Aventura","platform":"Switch"}'

# Listar juegos
curl http://127.0.0.1:8000/api/games
```

## 🐛 Solución Rápida de Problemas

### "php no se reconoce"
→ Usa la terminal de Laragon o agrega PHP al PATH

### "Class GameFactory not found"
```bash
composer dump-autoload
```

### "Database not found"
```bash
touch database/database.sqlite
php artisan migrate
```

### Tests fallan
```bash
php artisan migrate:fresh
php artisan test
```

## 📊 Estado del Proyecto

✅ **11/11 tests pasando**
✅ **CI/CD configurado**
✅ **Listo para GitHub**
✅ **Documentación completa**

## 🎯 Endpoints Disponibles

- `GET    /api/games`      - Listar todos
- `POST   /api/games`      - Crear nuevo
- `GET    /api/games/{id}` - Ver uno
- `PUT    /api/games/{id}` - Actualizar
- `DELETE /api/games/{id}` - Eliminar

---

**Servidor corriendo:** http://127.0.0.1:8000

**¡Todo listo para usar!** 🎉
