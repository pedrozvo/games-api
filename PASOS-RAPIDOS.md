# ⚡ Pasos Rápidos - Completar Proyecto

## 🚀 Orden de Ejecución (5-10 minutos)

### 1️⃣ Verificar que Docker funciona
```bash
# Ver que los contenedores estén corriendo
docker-compose ps
```

### 2️⃣ Probar la API con Docker
```bash
# Opción A: Navegador
http://localhost:8080/index.php/api/games

# Opción B: PowerShell
Invoke-WebRequest -Uri "http://localhost:8080/index.php/api/games" -UseBasicParsing

# Nota: Usa /index.php/ en la URL con Docker
```

### 3️⃣ Crear un juego de prueba
```bash
# En Postman:
# POST: http://localhost:8080/index.php/api/games
# Body (JSON):
{
  "title": "Zelda",
  "description": "Aventura épica",
  "genre": "Aventura",
  "platform": "Switch"
}
```

### 4️⃣ Ejecutar los tests
```bash
# Con Docker
docker-compose exec app php artisan test

# O local (si prefieres)
php artisan test
```

### 5️⃣ Subir a GitHub
```bash
# Inicializar git (si no está)
git init

# Agregar archivos
git add .

# Commit
git commit -m "feat: API completa con Docker, tests y CI/CD"

# Crear repo en GitHub y conectar
git remote add origin https://github.com/TU_USUARIO/games-api.git
git branch -M main
git push -u origin main
```

### 6️⃣ Verificar CI/CD en GitHub
1. Ve a GitHub → tu repositorio
2. Click en pestaña **"Actions"**
3. Los tests se ejecutarán automáticamente
4. Espera que salga ✅ verde

---

## ✅ Checklist Final

- [ ] Docker corriendo (`docker-compose ps`)
- [ ] API responde en http://localhost:8080/api/games
- [ ] Tests pasan (`php artisan test`)
- [ ] Código en GitHub
- [ ] GitHub Actions ✅ verde
- [ ] Documentación completa (ya está)

---

## 📋 Si algo falla

### Docker no levanta:
```bash
docker-compose down
docker-compose up -d --build
```

### Tests fallan:
```bash
php artisan migrate:fresh
php artisan test
```

### Git rechaza el push:
```bash
git pull origin main --rebase
git push origin main
```

---

## 🎯 Resultado Final

Tu proyecto tendrá:
- ✅ API funcionando en Docker
- ✅ 9 tests pasando
- ✅ CI/CD automático en GitHub
- ✅ Código en repositorio público
- ✅ Documentación completa

**Tiempo estimado: 5-10 minutos** ⏱️

---

## 🚀 Comandos de un Solo Vistazo

```bash
# 1. Verificar Docker
docker-compose ps

# 2. Probar API
curl http://localhost:8080/api/games

# 3. Tests
php artisan test

# 4. Git
git add .
git commit -m "feat: Proyecto final completo"
git push origin main
```

**¡Eso es todo!** 🎉
