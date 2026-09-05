# backendTemplate

Plantilla administrativa en Laravel 13 con PostgreSQL y arquitectura MVC.

## Incluye

- Primera pantalla únicamente para ingresar correo electrónico.
- Validación de existencia del correo antes de mostrar la pantalla de clave.
- Sin registro público de usuarios.
- Creación de usuarios desde el área autenticada.
- Clave genérica definida en `.env`.
- Cambio obligatorio de clave en el primer acceso.
- Autenticación de doble factor TOTP opcional.
- Pantalla principal.
- Configuración.
- Creación de roles.
- Asignación de roles.
- PostgreSQL.
- Controladores, modelos, vistas y nombres de negocio en español.
- Variables, métodos y columnas propias del sistema en camelCase.

## Requisitos

- PHP 8.3 a 8.5.
- Composer.
- PostgreSQL.
- Extensión PHP `pdo_pgsql` habilitada.

## Instalación

```bash
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Antes de migrar, cree la base de datos PostgreSQL indicada en `.env` y ajuste:

```env
DB_DATABASE=backendtemplate
DB_USERNAME=postgres
DB_PASSWORD=
```

También cambie los valores iniciales:

```env
ADMIN_NOMBRE=Administrador
ADMIN_CORREO=admin@backendtemplate.local
ADMIN_CLAVE=Temporal123!
CLAVE_GENERICA=Temporal123!
```

El administrador inicial también queda obligado a cambiar su clave en el primer acceso.

## Doble factor

El sistema genera una clave secreta TOTP y una URI `otpauth://`. La persona puede agregarla manualmente en una aplicación compatible como Google Authenticator o Microsoft Authenticator y confirmar con un código de 6 dígitos.

## Nota de nomenclatura

El código de negocio usa nombres en español y camelCase. Los nombres internos propios del framework o de archivos estándar de Laravel conservan la convención requerida por Laravel cuando corresponde.
