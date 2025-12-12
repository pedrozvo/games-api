# 🎮 Games API - Laravel

API REST desarrollada con Laravel para la gestión de videojuegos con CI/CD automatizado.

![Laravel CI/CD](https://github.com/pedrozvo/games-api/workflows/Laravel%20CI/CD/badge.svg)

## 📋 Descripción

Esta API permite gestionar un catálogo de videojuegos, proporcionando endpoints completos para crear, listar, actualizar y eliminar juegos. El proyecto incluye:

- ✅ CRUD completo de juegos
- ✅ Validaciones robustas con FormRequests
- ✅ Tests automatizados (Unit y Feature)
- ✅ CI/CD con GitHub Actions
- ✅ Factory para generación de datos de prueba
- ✅ Documentación completa con Postman

## 🛠️ Tecnologías

- **PHP**: ^8.2
- **Laravel**: ^12.0
- **Laravel Sanctum**: ^4.0 (Autenticación API)
- **PHPUnit**: ^11.5 (Testing)
- **SQLite/MySQL**: Base de datos configurable
- **GitHub Actions**: CI/CD automatizado

## 📦 Requisitos Previos

### Opción 1: Con Docker (Recomendado)
- Docker Desktop
- Docker Compose

### Opción 2: Sin Docker
- PHP 8.2 o superior
- Composer
- Node.js y NPM (opcional para frontend)
- SQLite o MySQL
- Git

## 🚀 Instalación Local (sin Docker)

Si prefieres usar Docker, ve a la sección [🐳 Instalación con Docker](#-instalación-con-docker-recomendado).

### Opción A: Con Docker (Recomendado) 🐳

```bash
# 1. Clonar el repositorio
git clone https://github.com/pedrozvo/games-api.git
cd games-api

# 2. Levantar con Docker Compose
docker-compose up -d

# 3. La API estará disponible en:
# http://localhost:8080/api/games
```

Ver [DOCKER.md](DOCKER.md) para más detalles.

### Opción B: Instalación Local

#### 1. Clonar el repositorio

```bash
git clone https://github.com/pedrozvo/games-api.git
cd games-api
```

#### 2. Instalación automática

```bash
composer setup
```

Este comando ejecutará automáticamente:
- Instalación de dependencias de Composer
- Copia del archivo `.env.example` a `.env`
- Generación de la clave de aplicación
- Ejecución de migraciones
- Instalación de dependencias de NPM
- Compilación de assets

#### 3. Instalación manual (alternativa)

```bash
# Instalar dependencias de PHP
composer install

# Copiar archivo de entorno
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate

# Crear base de datos SQLite
touch database/database.sqlite

# Ejecutar migraciones
php artisan migrate

# Instalar dependencias de Node (opcional)
npm install
npm run build
```

## 🎯 Uso

### Con Docker

```bash
# Levantar servicios
docker-compose up -d

# Ver logs
docker-compose logs -f app

# Detener servicios
docker-compose down
```

### Local

#### Iniciar el servidor de desarrollo

```bash
php artisan serve
```

El servidor estará disponible en `http://localhost:8000`

#### Ejecutar en modo desarrollo con watch

```bash
composer dev
```

Esto iniciará simultáneamente:
- Servidor Laravel
- Queue listener
- Pail (logs en tiempo real)
- Vite (compilación de assets)

## 📚 Endpoints de la API

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/api/games` | Listar todos los juegos |
| GET | `/api/games/{id}` | Obtener un juego específico |
| POST | `/api/games` | Crear un nuevo juego |
| PUT | `/api/games/{id}` | Actualizar un juego existente |
| DELETE | `/api/games/{id}` | Eliminar un juego |

### Ejemplo de petición POST

```bash
curl -X POST http://localhost:8000/api/games \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "title": "The Legend of Zelda",
    "description": "Epic adventure game",
    "genre": "Adventure",
    "platform": "Nintendo Switch"
  }'
```

### Respuesta exitosa (201 Created)

```json
{
  "id": 1,
  "title": "The Legend of Zelda",
  "description": "Epic adventure game",
  "genre": "Adventure",
  "platform": "Nintendo Switch",
  "created_at": "2025-12-11T10:30:00.000000Z",
  "updated_at": "2025-12-11T10:30:00.000000Z"
}
```

## 🧪 Testing

### Con Docker

```bash
# Ejecutar todos los tests
docker-compose exec app php artisan test

# Con cobertura
docker-compose exec app php artisan test --coverage

# Tests específicos
docker-compose exec app php artisan test --filter GameTest
```

### Local

#### Ejecutar todos los tests

```bash
php artisan test
```

#### Ejecutar tests con cobertura

```bash
php artisan test --coverage
```

#### Ejecutar tests específicos

```bash
php artisan test --filter GameTest
```

### Tests incluidos

- ✅ Test de listado de juegos
- ✅ Test de creación de juegos
- ✅ Test de validaciones
- ✅ Test de actualización
- ✅ Test de eliminación
- ✅ Test de búsqueda por ID
- ✅ Test de errores 404

## 🔄 CI/CD

El proyecto incluye GitHub Actions configurado para:

- ✅ Ejecutar tests automáticamente en cada push
- ✅ Verificar calidad de código con Laravel Pint
- ✅ Ejecutar migraciones en entorno de testing
- ✅ Generar reportes de tests

### Workflow

Los tests se ejecutan automáticamente cuando:
- Se hace push a las ramas `main` o `develop`
- Se crea un Pull Request hacia `main`

## 📮 Colección de Postman

El proyecto incluye una colección completa de Postman (`Games-API.postman_collection.json`) con todos los endpoints configurados.

### Importar en Postman

1. Abre Postman
2. Click en "Import"
3. Selecciona el archivo `Games-API.postman_collection.json`
4. Configura la variable `base_url` a `http://localhost:8000`

## 🗂️ Estructura del Proyecto

```
games-api/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/
│   │   │       └── GameController.php
│   │   └── Requests/
│   │       ├── StoreGameRequest.php
│   │       └── UpdateGameRequest.php
│   └── Models/
│       └── Game.php
├── database/
│   ├── factories/
│   │   └── GameFactory.php
│   └── migrations/
│       └── 2025_11_30_191417_create_games_table.php
├── tests/
│   └── Feature/
│       └── Api/
│           └── GameTest.php
├── docker/
│   ├── nginx.conf           ← Configuración Nginx
│   ├── supervisord.conf     ← Configuración Supervisor
│   └── start.sh             ← Script de inicio
├── .github/
│   └── workflows/
│       └── laravel.yml      ← CI/CD Pipeline
├── routes/
│   └── api.php
├── Dockerfile               ← Imagen Docker
├── docker-compose.yml       ← Orquestación de servicios
└── DOCKER.md                ← Documentación Docker
```

## 🔐 Validaciones

### Crear Juego (POST)

- `title`: Requerido, máximo 255 caracteres, único
- `description`: Requerido, máximo 1000 caracteres
- `genre`: Requerido, máximo 100 caracteres
- `platform`: Requerido, máximo 100 caracteres

### Actualizar Juego (PUT)

- `title`: Opcional, máximo 255 caracteres, único (ignorando el mismo juego)
- `description`: Opcional, máximo 1000 caracteres
- `genre`: Opcional, máximo 100 caracteres
- `platform`: Opcional, máximo 100 caracteres

## 🐛 Solución de Problemas

### Error: "Class GameFactory not found"

```bash
composer dump-autoload
```

### Error en migraciones

```bash
php artisan migrate:fresh
```

### Limpiar caché

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

## 📝 Licencia

Este proyecto está bajo la licencia MIT.

## 👥 Contribuciones

Las contribuciones son bienvenidas. Por favor:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📧 Contacto

- **Autor**: Pedro ZVO
- **GitHub**: [@pedrozvo](https://github.com/pedrozvo)
- **Repositorio**: [games-api](https://github.com/pedrozvo/games-api)

---

⭐ **¡Si te gusta este proyecto, dale una estrella en GitHub!** ⭐

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
