# 🎮 Games API

API REST desarrollada con Laravel para la gestión de videojuegos.

## 📋 Descripción

Esta API permite gestionar un catálogo de videojuegos, proporcionando endpoints para crear y listar juegos con información como título, descripción, género y plataforma.

## 🛠️ Tecnologías

- **PHP**: ^8.2
- **Laravel**: ^12.0
- **Laravel Sanctum**: ^4.0 (Autenticación API)
- **Base de datos**: SQLite/MySQL (configurable)

## 📦 Requisitos Previos

### Opción 1: Con Docker (Recomendado)
- Docker Desktop
- Docker Compose

### Opción 2: Sin Docker
- PHP 8.2 o superior
- Composer
- Node.js y NPM
- Base de datos (SQLite, MySQL, PostgreSQL, etc.)

## 🚀 Instalación Local (sin Docker)

Si prefieres usar Docker, ve a la sección [🐳 Instalación con Docker](#-instalación-con-docker-recomendado).

### 1. Clonar el repositorio

```bash
git clone <url-del-repositorio>
cd games-api
```

### 2. Instalación automática

```bash
composer setup
```

Este comando ejecutará:
- Instalación de dependencias de Composer
- Copia del archivo `.env.example` a `.env`
- Generación de la clave de aplicación
- Ejecución de migraciones
- Instalación de dependencias de NPM
- Compilación de assets

### 3. Configuración manual (alternativa)

```bash
# Instalar dependencias
composer install
npm install

# Configurar entorno
cp .env.example .env
php artisan key:generate

# Configurar base de datos en .env
# DB_CONNECTION=sqlite
# DB_DATABASE=/ruta/absoluta/a/database.sqlite

# Ejecutar migraciones
php artisan migrate

# Compilar assets
npm run build
```

## 🐳 Instalación con Docker (Recomendado)

Docker proporciona un entorno consistente y fácil de configurar sin necesidad de instalar PHP, Composer o MySQL localmente.

### Requisitos
- Docker Desktop instalado
- Docker Compose

### 1. Clonar el repositorio

```bash
git clone <url-del-repositorio>
cd games-api
```

### 2. Configurar variables de entorno

```bash
cp .env.example .env
```

Edita el archivo `.env` y configura las siguientes variables para Docker:

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=games_db
DB_USERNAME=laravel
DB_PASSWORD=secret
```

### 3. Construir y levantar los contenedores

```bash
docker-compose up -d --build
```

Este comando:
- Construye la imagen de Docker para Laravel
- Levanta los siguientes contenedores:
  - **app**: Aplicación Laravel (PHP-FPM)
  - **nginx**: Servidor web (puerto 8000)
  - **db**: Base de datos MySQL (puerto 3306)
  - **phpmyadmin**: Administrador de base de datos (puerto 8080)

### 4. Instalar dependencias y configurar la aplicación

```bash
# Generar clave de aplicación
docker-compose exec app php artisan key:generate

# Ejecutar migraciones
docker-compose exec app php artisan migrate

# (Opcional) Ejecutar seeders
docker-compose exec app php artisan db:seed
```

### 5. Acceder a la aplicación

- **API**: http://localhost:8000/api/games
- **phpMyAdmin**: http://localhost:8080 (usuario: `laravel`, contraseña: `secret`)

### Comandos útiles de Docker

```bash
# Ver logs de la aplicación
docker-compose logs -f app

# Ver logs de todos los servicios
docker-compose logs -f

# Ejecutar comandos Artisan
docker-compose exec app php artisan [comando]

# Acceder al contenedor
docker-compose exec app bash

# Ejecutar tests
docker-compose exec app php artisan test

# Detener los contenedores
docker-compose stop

# Detener y eliminar contenedores
docker-compose down

# Detener y eliminar contenedores con volúmenes (¡cuidado! elimina la BD)
docker-compose down -v
```

### Estructura de servicios Docker

| Servicio | Puerto | Descripción |
|----------|--------|-------------|
| nginx | 8000 | Servidor web principal |
| app | 9000 | Aplicación PHP-FPM |
| db | 3306 | Base de datos MySQL |
| phpmyadmin | 8080 | Administrador de base de datos |

## 🎯 Uso

### Iniciar servidor de desarrollo (sin Docker)

```bash
composer dev
```

Este comando iniciará simultáneamente:
- Servidor PHP (puerto 8000)
- Cola de trabajos
- Logs en tiempo real
- Servidor Vite para assets

### Iniciar servidor individualmente

```bash
php artisan serve
```

La API estará disponible en `http://localhost:8000`

## 📡 Endpoints

### Base URL
```
http://localhost:8000/api
```

### 1. Listar todos los juegos

**Endpoint:** `GET /api/games`

**Respuesta exitosa (200):**
```json
[
    {
        "id": 1,
        "title": "The Legend of Zelda: Breath of the Wild",
        "description": "Juego de aventura y acción en mundo abierto",
        "genre": "Aventura",
        "platform": "Nintendo Switch",
        "created_at": "2025-11-30T19:20:30.000000Z",
        "updated_at": "2025-11-30T19:20:30.000000Z"
    }
]
```

### 2. Crear un nuevo juego

**Endpoint:** `POST /api/games`

**Headers:**
```
Content-Type: application/json
```

**Body:**
```json
{
    "title": "The Legend of Zelda: Breath of the Wild",
    "description": "Juego de aventura y acción en mundo abierto",
    "genre": "Aventura",
    "platform": "Nintendo Switch"
}
```

**Respuesta exitosa (201):**
```json
{
    "id": 1,
    "title": "The Legend of Zelda: Breath of the Wild",
    "description": "Juego de aventura y acción en mundo abierto",
    "genre": "Aventura",
    "platform": "Nintendo Switch",
    "created_at": "2025-11-30T19:20:30.000000Z",
    "updated_at": "2025-11-30T19:20:30.000000Z"
}
```

**Validaciones:**
- `title`: Requerido
- `description`: Opcional
- `genre`: Requerido
- `platform`: Requerido

## 🗄️ Estructura de la Base de Datos

### Tabla: games

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | Identificador único (autoincremental) |
| title | VARCHAR(255) | Título del juego |
| description | TEXT | Descripción del juego |
| genre | VARCHAR(255) | Género (RPG, FPS, Aventura, etc.) |
| platform | VARCHAR(255) | Plataforma (PC, Switch, PlayStation, etc.) |
| created_at | TIMESTAMP | Fecha de creación |
| updated_at | TIMESTAMP | Fecha de última actualización |

## 🧪 Testing

### Ejecutar tests

```bash
composer test
```

O directamente:

```bash
php artisan test
```

### Tests disponibles

Los tests se encuentran en `tests/Feature/Api/GameTest.php` y verifican:
- Listado de juegos
- Creación de juegos
- Validaciones

## 📁 Estructura del Proyecto

```
games-api/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── Api/
│   │           └── GameController.php
│   └── Models/
│       └── Game.php
├── database/
│   ├── migrations/
│   │   └── 2025_11_30_191417_create_games_table.php
│   └── seeders/
├── routes/
│   └── api.php
└── tests/
    └── Feature/
        └── Api/
            └── GameTest.php
```

## 🔧 Scripts Disponibles

```bash
# Setup completo del proyecto
composer setup

# Iniciar entorno de desarrollo
composer dev

# Ejecutar tests
composer test

# Linter de código (PHP)
./vendor/bin/pint

# Compilar assets para producción
npm run build

# Modo desarrollo de assets
npm run dev
```

## 🔐 Autenticación (Sanctum)

El proyecto incluye Laravel Sanctum para autenticación API. Ejemplo de endpoint protegido:

```
GET /api/user
```

Este endpoint requiere autenticación mediante token Bearer.

## 🌍 Variables de Entorno

Principales variables a configurar en `.env`:

### Para desarrollo local (sin Docker):

```env
APP_NAME="Games API"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=sqlite
DB_DATABASE=/ruta/absoluta/a/database.sqlite

# O para MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=games_db
# DB_USERNAME=root
# DB_PASSWORD=
```

### Para Docker:

```env
APP_NAME="Games API"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=games_db
DB_USERNAME=laravel
DB_PASSWORD=secret
```

**Nota**: En Docker, `DB_HOST=db` hace referencia al nombre del servicio de base de datos definido en `docker-compose.yml`.

## 📝 Notas de Desarrollo

- Los modelos utilizan mass assignment con `$fillable`
- Las migraciones incluyen timestamps automáticos
- Se recomienda usar SQLite para desarrollo local
- El proyecto incluye GitHub Actions para CI/CD (opcional)


## 📄 Licencia

Este proyecto está bajo la licencia MIT. Consulta el archivo LICENSE para más detalles.

## 👨‍💻 Autor

Desarrollado para el curso de Transformación Digital - Inacap

---

**¿Problemas?** Abre un issue en el repositorio o contacta al equipo de desarrollo.
