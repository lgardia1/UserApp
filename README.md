# UserApp Mangament Users

Este proyecto es una aplicación Laravel puedes, verificar, crear y hacer login de un usuario. 
Ademas tiene un sitema de roles donde hay los siguientes:
- Usuario: Puede hacer las acciones basica de usuario, crearse una cuenta, hacer login, verificarse...
- Admin: Este debe serr asignado por otro admin o por el superadmin, hace las acciones basica de usuario pero este además puede cambiar el id, nombre, email , correo y verificar correo.
- SuperAdmin: Este es un admin pero tiene el id = 1 , pero tiene el privilegio de no ser borrado ni editado por otros admins.

## Funcionalidades

### Listar Usuarios (Admin y SuperAdmin)
- **ID**: Identificador único del Pokémon.
- **Nombre**: Nombre del usuario.
- **Email**: Correo del usuario
- **Role**: Tipo de usuario (user, admin).
- **Verifcacion**: Si esta verificado muestra la fecha de verificaion en caso contrario, un boton para verificar

### Creacion de usuario
Creacion de usuario, login, recuprecion y cambios de contraseña, y verifición de email.
- **Nombre**: Nombre del usuario.
- **Email**: Correo del usuario
- **Contraseña**: Contrase dle usuario
- **Role**: Al crearse el usurio porfevto tiene el rol de **user**.

# Instalación

1. Clona el repositorio.
2. Instala las dependencias con Composer:
```sh
composer install
```
3. Dar permisos con `chown` y `chmod`.
4. Configura tu archivo `.env` con los detalles de tu base de datos.
5. Ejecuta las migraciones para crear las tablas necesarias:
```sh
php artisan migrate
```
6. Ejecuta el seeder para comprobar el funcionamiento de la app:
```sh
php artisan db:seed
```
7. Inicia el servidor de desarrollo:
```sh
php artisan serve
```



