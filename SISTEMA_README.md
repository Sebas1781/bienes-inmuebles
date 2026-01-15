# Sistema de Gestión de Bienes Inmuebles

Sistema completo para la administración y control de bienes inmuebles desarrollado en Laravel.

## 🚀 Características

### Gestión de Inmuebles
- ✅ Registro de inmuebles con información detallada
- ✅ Tipos de inmueble: Casa, Apartamento, Local Comercial, Oficina, Terreno, Bodega, Edificio
- ✅ Control de estados de ocupación: Disponible, Ocupado, Reservado, En Proceso
- ✅ Control de estados de mantenimiento: Excelente, Bueno, Regular, Requiere Mantenimiento, En Reparación
- ✅ Dashboard con estadísticas en tiempo real
- ✅ Modales interactivos para ver detalles de tipos y estados

### Sistema de Usuarios
- ✅ Tres niveles de acceso:
  - **Usuario**: Visualización de inmuebles
  - **Administrador**: Gestión completa de inmuebles
  - **Super Administrador**: Control total del sistema + gestión de usuarios

### Dashboard Interactivo
- 📊 Tarjetas con contadores dinámicos
- 🔍 Modales con detalles al hacer clic en tarjetas
- 📈 Estadísticas en tiempo real

## 📋 Requisitos

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL o PostgreSQL

## 🛠️ Instalación

1. **Clonar el repositorio**
```bash
git clone <tu-repositorio>
cd bienes-inmuebles
```

2. **Instalar dependencias**
```bash
composer install
npm install
```

3. **Configurar el archivo .env**
```bash
cp .env.example .env
php artisan key:generate
```

Configura tu base de datos en el archivo `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bienes_inmuebles
DB_USERNAME=root
DB_PASSWORD=
```

4. **Ejecutar migraciones y seeders**
```bash
php artisan migrate:fresh --seed
```

Esto creará:
- 3 usuarios de prueba
- 6 inmuebles de ejemplo

5. **Compilar assets**
```bash
npm run dev
```

En otra terminal:
```bash
php artisan serve
```

## 👤 Usuarios de Prueba

Después de ejecutar los seeders, tendrás estos usuarios disponibles:

| Email | Password | Rol |
|-------|----------|-----|
| superadmin@example.com | password | Super Administrador |
| admin@example.com | password | Administrador |
| usuario@example.com | password | Usuario |

## 📱 Funcionalidades por Rol

### Super Administrador
- ✅ Acceso completo al sistema
- ✅ Gestión de usuarios (crear, editar, eliminar)
- ✅ Gestión de inmuebles
- ✅ Visualización de todas las estadísticas

### Administrador
- ✅ Gestión completa de inmuebles
- ✅ Visualización de estadísticas
- ❌ No puede gestionar usuarios

### Usuario
- ✅ Visualización de inmuebles
- ❌ No puede crear, editar o eliminar

## 🎨 Estructura del Proyecto

```
app/
├── Http/Controllers/
│   ├── DashboardController.php
│   ├── PropertyController.php
│   └── UserManagementController.php
├── Models/
│   ├── Property.php
│   └── User.php

resources/
├── views/
│   ├── dashboard.blade.php
│   ├── properties/
│   │   └── create.blade.php
│   └── users/
│       ├── index.blade.php
│       ├── create.blade.php
│       └── edit.blade.php

routes/
└── web.php
```

## 🔄 Rutas Principales

```php
GET  /dashboard              - Dashboard principal
GET  /properties/create      - Formulario para agregar inmueble
POST /properties             - Guardar nuevo inmueble
GET  /users                  - Gestión de usuarios (solo super admin)
GET  /users/create           - Crear nuevo usuario
POST /users                  - Guardar nuevo usuario
```

## 🎯 Próximas Mejoras

- [ ] Búsqueda y filtros avanzados
- [ ] Exportación de reportes (PDF, Excel)
- [ ] Galería de imágenes para inmuebles
- [ ] Sistema de notificaciones
- [ ] Historial de cambios
- [ ] API REST
- [ ] Aplicación móvil

## 🤝 Contribuir

Las contribuciones son bienvenidas. Por favor:
1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📝 Licencia

Este proyecto es de código abierto bajo la licencia MIT.

## 👨‍💻 Desarrollado con

- [Laravel 11](https://laravel.com)
- [Tailwind CSS](https://tailwindcss.com)
- [Font Awesome](https://fontawesome.com)
- [Vite](https://vitejs.dev)

---

¿Preguntas o sugerencias? Abre un issue en el repositorio.
