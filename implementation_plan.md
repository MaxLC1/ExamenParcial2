# Plan de Refactorización a Arquitectura Modular

El objetivo es migrar todos los Casos de Uso (CU) del proyecto actual (un sistema de admisiones o academia) a una estructura de módulos (Domain-Driven Design), basándonos en el estilo de nombrado de tu imagen de referencia (`P1_...`, `P2_...`), pero adaptando los nombres al dominio real de tu proyecto actual.

Actualmente, tus rutas y controladores definen 13 Casos de Uso. Los agruparemos en 6 módulos principales.

## User Review Required
> [!IMPORTANT]
> **Revisión de Nombres de Módulos**
> Como tu proyecto actual es una Academia y la foto que me mostraste era de un Salón de Belleza (Inventario, Citas, etc.), he adaptado los nombres de los paquetes para que tengan sentido con tu código actual, pero manteniendo el formato `PX_Nombre`. ¿Estás de acuerdo con este mapeo?

## Propuesta de Módulos (Mapeo de Casos de Uso)

Aquí te presento cómo quedarían agrupados tus Casos de Uso (CU) en los paquetes:

### 1. P1_GestionUsuarioSeguridad
Se encargará de la autenticación, roles y la vista principal.
- **CU2**: Autenticación y Panel de Control (Dashboard)
- **CU13**: Gestionar Usuarios y Roles
- *Controladores implicados*: `DashboardController`, `UsuarioController`, `ProfileController`

### 2. P2_GestionProfesoresPostulantes (Equivalente a Personal y Clientes)
Se encargará de las personas del sistema.
- **CU1**: Registro público de postulantes
- **CU4**: Gestionar Profesores
- **CU5**: Gestionar Postulantes
- *Controladores implicados*: `ProfesorController`, `PostulanteController`

### 3. P3_GestionAcademica (Equivalente a Inventario)
Se encargará de la estructura de la academia.
- **CU3**: Gestionar Gestiones Académicas
- **CU6**: Gestionar Grupos
- **CU7**: Asignar Postulantes a Grupos
- *Controladores implicados*: `GestionController`, `GrupoController`

### 4. P4_GestionEvaluacionAsistencia (Equivalente a Servicios/Citas)
Se encargará del día a día de las clases.
- **CU9**: Programar Exámenes
- **CU10**: Registrar Asistencias
- **CU11**: Calificar Exámenes
- *Controladores implicados*: `ExamenController`, `AsistenciaController`

### 5. P5_PagosFacturacion
Se encargará del dinero.
- **CU12**: Control Historial de Pagos
- *Controladores implicados*: `PagoController`

### 6. P6_ReportesComunicaciones
Se encargará de los resultados y listados.
- **CU8**: Generar Reportes y Resultados (y asignar carreras)
- *Controladores implicados*: `ReporteController`

---

## Proposed Changes

Si apruebas este plan, procederé con los siguientes pasos técnicos:

1. **Crear los 6 Módulos** usando Artisan (`php artisan module:make ...`).
2. **Mover Modelos**: Mover los modelos (`User`, `Profesor`, `Postulante`, `Examen`, etc.) a la carpeta `app/Modules/.../Models`.
3. **Mover Controladores**: Trasladar los controladores correspondientes a `app/Modules/.../Http/Controllers`.
4. **Refactorizar Rutas**: Separar tu archivo actual `routes/web.php` y repartir las rutas en el archivo `routes/web.php` de cada módulo correspondiente.
5. **Ajustar Namespaces**: Actualizar todos los `use App\Models\...` a los nuevos namespaces de los módulos.
6. **Mover Vistas**: (Opcional en esta fase inicial, pero recomendable) Mover las vistas de Blade a la carpeta de recursos de cada módulo.

## Verification Plan
1. Ejecutar `php artisan optimize:clear`.
2. Verificar que el comando `php artisan route:list` muestre todas las rutas correctamente registradas sin errores de "Class not found".
3. Validar que la aplicación carga sin arrojar excepciones de dependencias.
