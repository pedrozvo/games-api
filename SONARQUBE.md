# SonarQube - Análisis de Calidad de Código

## 📋 ¿Qué es SonarQube?

**SonarQube** es una plataforma de análisis de calidad de código que detecta:

- 🐛 **Bugs** - Errores en el código
- 🔒 **Vulnerabilidades** - Problemas de seguridad
- 💩 **Code Smells** - Código que necesita refactorización
- 📊 **Cobertura de tests** - Porcentaje de código testeado
- 🔄 **Duplicación** - Código duplicado
- 📈 **Complejidad** - Complejidad ciclomática del código
- 📏 **Métricas** - Líneas de código, deuda técnica, etc.

---

## 🚀 Opción 1: SonarCloud (Recomendado para Proyectos en GitHub)

### Ventajas
✅ Gratis para proyectos públicos  
✅ No requiere instalación local  
✅ Integración automática con GitHub  
✅ Reportes visuales en la nube  

### Configuración de SonarCloud

#### Paso 1: Crear cuenta en SonarCloud

1. Ve a [https://sonarcloud.io](https://sonarcloud.io)
2. Inicia sesión con tu cuenta de GitHub
3. Autoriza el acceso a tu organización/repositorio

#### Paso 2: Configurar el proyecto

1. En SonarCloud, haz clic en **"+"** → **"Analyze new project"**
2. Selecciona tu repositorio `games-api`
3. Configura el proyecto:
   - **Organization**: Tu usuario/organización de GitHub
   - **Project Key**: `tu-usuario_games-api`
   - **Display Name**: Games API

#### Paso 3: Obtener el token

1. En SonarCloud, ve a **My Account** → **Security**
2. Genera un nuevo token con nombre `games-api-token`
3. Copia el token generado

#### Paso 4: Configurar secrets en GitHub

1. Ve a tu repositorio en GitHub
2. Navega a **Settings** → **Secrets and variables** → **Actions**
3. Haz clic en **"New repository secret"**
4. Agrega el secret:
   - Name: `SONAR_TOKEN`
   - Value: (pega el token de SonarCloud)

#### Paso 5: Actualizar workflow

Edita el archivo `.github/workflows/sonarcloud.yml` y reemplaza:

```yaml
-Dsonar.organization=tu-organizacion
-Dsonar.projectKey=tu-proyecto-key
```

Con tus datos reales de SonarCloud.

#### Paso 6: Push y ver resultados

```bash
git add .
git commit -m "feat: Integrar SonarCloud para análisis de calidad"
git push origin main
```

Ve a la pestaña **"Actions"** en GitHub para ver el análisis ejecutándose.  
Los resultados estarán en [https://sonarcloud.io/project/overview?id=tu-proyecto-key](https://sonarcloud.io)

---

## 🐳 Opción 2: SonarQube Local con Docker

### Ventajas
✅ Control total sobre los datos  
✅ Funciona sin internet  
✅ Ideal para proyectos privados  

### Configuración de SonarQube Local

#### Paso 1: Levantar SonarQube

```bash
docker-compose -f docker-compose.sonar.yml up -d
```

Espera 2-3 minutos para que SonarQube inicie completamente.

#### Paso 2: Acceder a SonarQube

1. Abre tu navegador en: [http://localhost:9000](http://localhost:9000)
2. Credenciales por defecto:
   - **Usuario**: `admin`
   - **Contraseña**: `admin`
3. Te pedirá cambiar la contraseña (elige una segura)

#### Paso 3: Crear proyecto

1. En SonarQube, haz clic en **"Create new project"**
2. Project key: `games-api`
3. Display name: `Games API`
4. Haz clic en **"Set Up"**

#### Paso 4: Generar token

1. Selecciona **"Locally"**
2. Genera un token con nombre `games-api-token`
3. Copia el token (lo necesitarás en el siguiente paso)

#### Paso 5: Instalar SonarScanner

**Opción A - Con Composer:**

```bash
composer require --dev sonarqube/sonar-scanner-engine
```

**Opción B - Descargar manualmente:**

1. Descarga desde: [https://docs.sonarqube.org/latest/analysis/scan/sonarscanner/](https://docs.sonarqube.org/latest/analysis/scan/sonarscanner/)
2. Extrae y agrega al PATH

#### Paso 6: Ejecutar análisis

```bash
# Windows
sonar-scanner.bat -Dsonar.login=TU_TOKEN_AQUI

# Linux/Mac
sonar-scanner -Dsonar.login=TU_TOKEN_AQUI
```

O con Docker:

```bash
docker run --rm \
  --network="host" \
  -v "$(pwd):/usr/src" \
  sonarsource/sonar-scanner-cli \
  -Dsonar.host.url=http://localhost:9000 \
  -Dsonar.login=TU_TOKEN_AQUI
```

#### Paso 7: Ver resultados

Ve a [http://localhost:9000/dashboard?id=games-api](http://localhost:9000/dashboard?id=games-api)

---

## 📊 Métricas que proporciona SonarQube

### 1. **Bugs**
Errores de lógica que pueden causar comportamiento inesperado.

### 2. **Vulnerabilidades**
Problemas de seguridad que pueden ser explotados (SQL injection, XSS, etc.).

### 3. **Code Smells**
Código que funciona pero es difícil de mantener:
- Funciones demasiado largas
- Código duplicado
- Complejidad alta
- Variables no usadas

### 4. **Cobertura de Tests**
Porcentaje de código cubierto por tests unitarios.

### 5. **Duplicación**
Porcentaje de código duplicado en el proyecto.

### 6. **Deuda Técnica**
Tiempo estimado para resolver todos los problemas detectados.

### 7. **Rating de Calidad**
Calificación de A (excelente) a E (pobre) en:
- Fiabilidad (Bugs)
- Seguridad (Vulnerabilidades)
- Mantenibilidad (Code Smells)

---

## 🎯 Configuración Avanzada

### Integrar cobertura de tests

Edita `phpunit.xml` y agrega:

```xml
<coverage>
    <report>
        <clover outputFile="coverage.xml"/>
    </report>
</coverage>
```

Ejecuta tests con cobertura:

```bash
vendor/bin/phpunit --coverage-clover=coverage.xml
```

Descomenta en `sonar-project.properties`:

```properties
sonar.php.coverage.reportPaths=coverage.xml
```

### Excluir archivos específicos

Edita `sonar-project.properties`:

```properties
sonar.exclusions=\
    **/vendor/**,\
    **/MiArchivoAIgnorar.php
```

---

## 🔧 Comandos Útiles

### SonarQube Local

```bash
# Iniciar SonarQube
docker-compose -f docker-compose.sonar.yml up -d

# Ver logs
docker-compose -f docker-compose.sonar.yml logs -f

# Detener SonarQube
docker-compose -f docker-compose.sonar.yml down

# Eliminar datos (reset completo)
docker-compose -f docker-compose.sonar.yml down -v
```

### Análisis Manual

```bash
# Análisis básico
sonar-scanner

# Análisis con token
sonar-scanner -Dsonar.login=TU_TOKEN

# Análisis con servidor personalizado
sonar-scanner -Dsonar.host.url=http://localhost:9000
```

---

## 📈 Interpretación de Resultados

### Rating A
✅ **Excelente** - 0 bugs/vulnerabilidades, < 5% de deuda técnica

### Rating B
✅ **Bueno** - Algunos code smells menores

### Rating C
⚠️ **Aceptable** - Necesita mejoras

### Rating D
❌ **Malo** - Problemas importantes

### Rating E
❌ **Muy malo** - Crítico, requiere refactorización urgente

---

## 🎓 Para el Proyecto del Profesor

### Evidencia que puedes mostrar:

1. **Screenshot del Dashboard de SonarQube** con las métricas
2. **Badge de SonarCloud** en el README (si usas SonarCloud)
3. **Reporte PDF** exportado desde SonarQube
4. **Configuración en GitHub Actions** (`.github/workflows/sonarcloud.yml`)
5. **Archivo de configuración** (`sonar-project.properties`)

### Badge para README (SonarCloud)

Agrega esto a tu `README.md`:

```markdown
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=TU_PROJECT_KEY&metric=alert_status)](https://sonarcloud.io/dashboard?id=TU_PROJECT_KEY)
```

---

## 🔗 Recursos Adicionales

- [Documentación SonarQube](https://docs.sonarqube.org/)
- [Documentación SonarCloud](https://sonarcloud.io/documentation)
- [SonarPHP Rules](https://rules.sonarsource.com/php/)
- [Best Practices](https://docs.sonarqube.org/latest/user-guide/clean-code/)

---

## ⚡ Quick Start (Resumen)

### Para SonarCloud:
1. Registrarse en sonarcloud.io
2. Conectar repositorio GitHub
3. Agregar `SONAR_TOKEN` en GitHub Secrets
4. Push al repo → análisis automático

### Para SonarQube Local:
1. `docker-compose -f docker-compose.sonar.yml up -d`
2. Acceder a http://localhost:9000
3. Crear proyecto y generar token
4. Ejecutar `sonar-scanner -Dsonar.login=TOKEN`
5. Ver resultados en el dashboard

