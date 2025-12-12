# PHPStan y Larastan - Análisis Estático de Código

## 📋 ¿Qué es?

**PHPStan** es una herramienta de análisis estático que encuentra errores en tu código PHP sin ejecutarlo.

**Larastan** es una extensión de PHPStan específica para Laravel que entiende Eloquent, Facades, helpers y otras características de Laravel.

## 🚀 Instalación

### Paso 1: Instalar dependencias

Ejecuta uno de estos comandos según tu entorno:

```bash
# Con Composer local
composer install

# Con Docker Compose
docker-compose exec app composer install

# Con Laravel Sail
./vendor/bin/sail composer install
```

## 📊 Uso

### Análisis básico

```bash
# Con Composer
composer phpstan

# Con Docker
docker-compose exec app composer phpstan

# Con Sail
./vendor/bin/sail composer phpstan
```

### Generar baseline (línea base)

Si tienes muchos errores existentes, puedes crear un baseline para ignorarlos temporalmente:

```bash
composer phpstan-baseline
```

Esto creará un archivo `phpstan-baseline.neon` con los errores actuales, permitiéndote enfocarte solo en errores nuevos.

## ⚙️ Configuración

El archivo `phpstan.neon` contiene la configuración:

- **Nivel de análisis**: Actualmente en nivel 5 (rango 0-9)
- **Directorios analizados**: app, config, database, routes
- **Nivel recomendado**: Empieza en 5, sube gradualmente hasta 8-9

### Cambiar el nivel de análisis

Edita `phpstan.neon` y modifica:

```yaml
parameters:
    level: 5  # Cambia este número (0-9)
```

## 📈 Niveles de análisis

- **Nivel 0-2**: Básico - errores graves
- **Nivel 3-5**: Intermedio - tipos incorrectos, métodos inexistentes
- **Nivel 6-7**: Avanzado - análisis profundo de tipos
- **Nivel 8-9**: Estricto - máxima rigurosidad

## 🐛 Tipos de errores que detecta

✅ Variables no definidas  
✅ Métodos inexistentes  
✅ Tipos de datos incorrectos  
✅ Retornos inconsistentes  
✅ Propiedades no existentes  
✅ Código inalcanzable  
✅ Condiciones siempre verdaderas/falsas  

## 💡 Ejemplo

```php
// ❌ PHPStan detectará este error:
public function show(int $id): User
{
    return User::find($id); // Error: puede retornar null
}

// ✅ Correcto:
public function show(int $id): ?User
{
    return User::find($id); // Ahora es explícito que puede ser null
}
```

## 🔗 Integración con CI/CD

Puedes agregar PHPStan a tu pipeline de CI/CD:

```yaml
# Ejemplo para GitHub Actions
- name: Run PHPStan
  run: composer phpstan
```

## 📚 Recursos

- [Documentación PHPStan](https://phpstan.org/)
- [Documentación Larastan](https://github.com/larastan/larastan)

## 🎯 Recomendaciones

1. **Empieza con nivel 5** y sube gradualmente
2. **Usa baseline** si tienes un proyecto existente con muchos errores
3. **Ejecuta PHPStan antes de cada commit** para prevenir errores
4. **Integra con tu IDE** (muchos IDEs tienen plugins de PHPStan)
5. **Sube el nivel** cuando resuelvas todos los errores del nivel actual

