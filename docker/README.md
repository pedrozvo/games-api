# 📁 Configuración Docker

Este directorio contiene los archivos de configuración para el despliegue con Docker.

## Archivos

### `nginx.conf`
Configuración de Nginx para servir la aplicación Laravel.

- Escucha en el puerto 80
- Root apunta a `/var/www/html/public`
- Configuración FastCGI para PHP-FPM
- Manejo de archivos estáticos

### `supervisord.conf`
Configuración de Supervisor para gestionar procesos.

**Procesos gestionados:**
- PHP-FPM (puerto 9000)
- Nginx (puerto 80)

Supervisor mantiene estos procesos corriendo y los reinicia si fallan.

### `start.sh`
Script de inicio que se ejecuta cuando el contenedor arranca.

**Acciones:**
1. Crea `.env` si no existe
2. Genera `APP_KEY` si es necesario
3. Crea base de datos SQLite
4. Ejecuta migraciones
5. Optimiza la aplicación (cache de config, routes, views)
6. Ajusta permisos
7. Inicia Supervisor

## Uso

Estos archivos son utilizados automáticamente por:
- `Dockerfile` - Para construir la imagen
- `docker-compose.yml` - Para orquestar los servicios

No es necesario modificarlos para uso normal.

## Modificar Configuración

### Cambiar puerto de Nginx

Edita `nginx.conf`:
```nginx
listen 8080;  # Cambiar de 80 a 8080
```

### Agregar procesos a Supervisor

Edita `supervisord.conf` y agrega:
```ini
[program:tu-proceso]
command=/ruta/al/comando
autostart=true
autorestart=true
```

### Personalizar inicio

Edita `start.sh` para agregar tus propios comandos de inicialización.

## Debugging

Ver logs de los procesos:
```bash
# Logs de Nginx
docker-compose exec app tail -f /var/log/nginx/error.log

# Logs de Supervisor
docker-compose exec app supervisorctl status
docker-compose exec app supervisorctl tail -f php-fpm
```
