<p align="center">
  <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/Uagrm-logo.png/600px-Uagrm-logo.png" width="150" alt="UAGRM Logo">
</p>

# FICCT — Sistema de Admisión Universitaria (CUP)

> Sistema web profesional para la gestión integral del proceso de ingreso al curso preuniversitario de la FICCT

---

## 🚀 Inicio Rápido

```bash
# 1. Instalar dependencias PHP
composer install

# 2. Instalar dependencias JS
npm install

# 3. Configurar entorno
cp .env.example .env
php artisan key:generate

# 4. Base de datos
php artisan migrate:fresh --seed

# 5. Generar cuentas de prueba por defecto
php artisan db:seed --class=RolesProfesoresSeeder

# 6. Compilar assets
npm run build          # Producción
# o
npm run dev            # Desarrollo (hot reload)

# 7. Iniciar servidor
php artisan serve
```

---

## 📋 Credenciales de Prueba

| Correo | Rol | Contraseña |
|---|---|---|
| `admin@ficct.edu.bo` | Administrador | `admin123` |
| `coordinador@ficct.edu.bo` | Coordinador (Admin) | `Password123` |
| `alerios839@gmail.com` | Autoridad | `8428287` |
| `computacion@ficct.edu.bo` | Profesor (Computación) | `Password123` |
| `matematicas@ficct.edu.bo` | Profesor (Matemáticas) | `Password123` |
| `fisica@ficct.edu.bo` | Profesor (Física) | `Password123` |
| `ingles@ficct.edu.bo` | Profesor (Inglés) | `Password123` |
| `alerivera157@gmail.com` | Postulante (Alumno) | `9646795` |
| `melcastellanos179@gmail.com` | Postulante (Alumno) | `8766833` |
| `nicvelasco689@gmail.com` | Postulante (Alumno) | `7735170` |

---

## 🏗 Arquitectura del Proyecto

Este sistema usa una **arquitectura de monolito modular** con Laravel. Los módulos se encuentran organizados dentro de `app/Modules/` y cada uno maneja sus propios Modelos, Controladores y Rutas, garantizando un código limpio y escalable.

### Estructura de Carpetas

```text
ficct-cup/                            ← Raíz del proyecto Laravel
├── app/                              ← 🔧 BACKEND (Lógica del servidor)
│   ├── Http/                         
│   │   ├── Controllers/              │  Controladores globales (Auth/Profile)
│   │   └── Middleware/               │  RoleMiddleware (Seguridad de Roles)
│   ├── Models/                       │  Modelos globales (User)
│   ├── Modules/                      │  ⭐ MÓDULOS DEL NEGOCIO (Domain-Driven)
│   │   ├── P1GestionUsuarioSeguridad/
│   │   │   └── (Gestión de usuarios, roles y accesos)
│   │   ├── P2GestionProfesoresPostulantes/
│   │   │   ├── Controllers/          │  ProfesorController, PostulanteController
│   │   │   └── Models/               │  Profesor, Postulante
│   │   ├── P3GestionAcademica/
│   │   │   ├── Controllers/          │  CarreraController, MateriaController, GrupoController
│   │   │   └── Models/               │  Carrera, Materia, Grupo, Gestion, Horario
│   │   ├── P4GestionEvaluacionAsistencia/
│   │   │   ├── Controllers/          │  ExamenController
│   │   │   └── Models/               │  Examen, Calificacion, Asistencia
│   │   ├── P5PagosFacturacion/
│   │   │   └── (Lógica de pagos y pasarelas)
│   │   └── P6ReportesComunicaciones/
│   │       ├── Controllers/          │  ReporteController
│   │       └── Views/                │  Vistas y lógicas de exportación PDF
│   └── Services/                     │  ⭐ SERVICIOS DE NEGOCIO REUTILIZABLES
│       ├── CalificacionService.php   │  Cálculos automáticos de aprobación (>=60)
│       ├── GrupoService.php          │  Distribución automática de alumnos
│       └── PostulanteService.php     │  Lógica de asignación de carreras
│
├── database/                         ← 🗃 BASE DE DATOS
│   ├── migrations/                   │  Esquemas relacionales
│   └── seeders/
│       ├── DatabaseSeeder.php        │  Seeder orquestador
│       ├── AdminSeeder.php           │  Usuario administrador inicial
│       ├── CarreraSeeder.php         │  Carreras predeterminadas (Ing. Sistemas, etc.)
│       └── RolesProfesoresSeeder.php │  ⭐ Profesores de prueba y Coordinador
│
├── resources/                        ← 🎨 FRONTEND (Vistas y assets)
│   ├── views/
│   │   ├── auth/                     │  Login, Register (Laravel Breeze)
│   │   ├── layouts/
│   │   │   ├── app.blade.php         │  Layout principal estructurado
│   │   │   └── navigation.blade.php  │  Barra de navegación responsiva
│   │   ├── dashboard.blade.php       │  Panel principal con indicadores y KPIs
│   │   ├── grupos/                   │  Vistas de grupos y asignación de materias
│   │   ├── postulantes/              │  CRUD y vistas de importación CSV/Excel
│   │   └── reportes/                 │  Interfaces premium y plantillas PDF (DOMPDF)
│   └── css/                          │  Configuraciones TailwindCSS globales
│
├── public/                           ← 📁 Archivos públicos
├── routes/                           
│   └── web.php                       │  Rutas principales web protegidas
├── .env                              ← Variables de entorno (Conexión PostgreSQL)
├── composer.json                     ← Dependencias PHP
├── tailwind.config.js                ← Tokens de diseño (Colores institucionales)
└── vite.config.js                    ← Bundler para Tailwind y Alpine
```

---

## 🔐 Seguridad y Lógica de Negocio

- **Validación Estricta:** Implementación rigurosa de Request Validation tanto en el frontend (HTML5/JS) como en el backend (Laravel validation).
- **Protección de Rutas:** Uso de Middleware personalizado `RoleMiddleware` para separar permisos entre `admin` y `profesor`.
- **Cálculos Automáticos:** El sistema evalúa silenciosamente los promedios matemáticos y asigna automáticamente el estado (`Aprobado`/`Reprobado` en base a 60 puntos).
- **Distribución de Cargas:** El sistema divide dinámicamente los grupos según un límite establecido (Ej. máximo 70 alumnos) mediante cálculos con `ceil()`.
- **Importación Masiva:** Seguridad en el procesamiento de archivos Excel/CSV para creación automatizada de cuentas.

---

## 📦 Tecnologías y Librerías

| Tecnología / Paquete | Uso Principal |
|---|---|
| **PHP ^8.2** | Lenguaje central del servidor |
| **Laravel ^11.9** | Framework robusto para backend |
| **PostgreSQL** | Motor de base de datos relacional |
| **Laravel Breeze** | Sistema de autenticación base |
| **TailwindCSS** | Framework utilitario para diseño UI "Premium" |
| **Alpine.js** | Interactividad ligera en el frontend |
| **barryvdh/laravel-dompdf** | Generación y exportación de reportes PDF |
| **Maatwebsite/Excel** | Procesamiento e importación de lotes CSV/Excel |
