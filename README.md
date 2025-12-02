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

- PHP 8.2 o superior
- Composer
- Node.js y NPM
- Base de datos (SQLite, MySQL, PostgreSQL, etc.)

## 🚀 Instalación

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

## 🎯 Uso

### Iniciar servidor de desarrollo

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
