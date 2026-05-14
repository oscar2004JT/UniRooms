# UniRooms

UniRooms es una plataforma web orientada al alojamiento universitario. El proyecto conecta estudiantes que buscan habitación con propietarios que desean publicar y administrar sus espacios, facilitando la búsqueda, visualización de detalles, gestión de favoritos y envío de solicitudes de reserva.

La aplicación fue desarrollada con Laravel y contempla flujos diferenciados para estudiantes y propietarios, incluyendo autenticación, perfiles, publicación de habitaciones, consulta de solicitudes y administración básica del proceso de arriendo.

## Objetivo del proyecto

El propósito de UniRooms es centralizar en una sola plataforma el proceso de búsqueda y oferta de habitaciones o pensiones para estudiantes, especialmente en zonas universitarias. El sistema busca hacer más confiable la conexión entre ambas partes mediante información estructurada, perfiles, filtros de búsqueda y control de reservas.

## Funcionalidades principales

### Para estudiantes

- Registro e inicio de sesión.
- Exploración de habitaciones disponibles.
- Filtros por zona, tipo de habitación y precio.
- Vista de detalle de cada habitación.
- Consulta del perfil público del propietario.
- Guardado de habitaciones en favoritos.
- Envío de solicitudes de reserva.
- Visualización y cancelación de reservas realizadas.

### Para propietarios

- Registro e inicio de sesión.
- Publicación de nuevas habitaciones.
- Carga de imágenes para las habitaciones.
- Gestión de habitaciones publicadas.
- Visualización detallada de cada publicación.
- Edición de información de la habitación.
- Revisión de solicitudes de reserva recibidas.
- Aceptación o rechazo de solicitudes.
- Consulta del perfil del estudiante asociado a una reserva.

## Tecnologías utilizadas

- `PHP 8.2`
- `Laravel 12`
- `Laravel Jetstream`
- `Laravel Fortify`
- `Laravel Sanctum`
- `Livewire`
- `Blade`
- `Tailwind CSS`
- `Vite`
- `MySQL`
- `Cloudinary` para almacenamiento de imágenes

## Estructura general del sistema

El proyecto está organizado bajo una arquitectura MVC usando Laravel:

- `app/Http/Controllers`: lógica de negocio para habitaciones, favoritos, reservas y gestión del propietario.
- `app/Models`: modelos del dominio como `Pension`, `Arriendo`, `Favorita`, `Persona`, `Estudiante` y `Propietario`.
- `database/migrations`: definición de la base de datos y relaciones entre entidades.
- `resources/views`: vistas Blade del frontend para estudiantes, propietarios, autenticación y perfiles.
- `routes/web.php`: rutas principales de navegación y acciones del sistema.

## Modelo de negocio implementado

UniRooms maneja dos roles principales:

- `Estudiante`: busca habitaciones, guarda favoritas y solicita reservas.
- `Propietario`: publica habitaciones, administra sus anuncios y responde a solicitudes.

Entre las entidades más importantes del sistema se encuentran:

- `users` y `roles`
- `persona`, `estudiante` y `propietario`
- `pension`
- `tipo_habitacion`, `tipo_servicio`, `tipo_estado` y `zona`
- `favorita`
- `arriendo`

Esto permite modelar tanto la información personal de los usuarios como la operación funcional del sistema de alojamiento.

## Mi participación en el desarrollo

Participé en todas las fases del desarrollo del proyecto, no solo en la programación final. Mi aporte abarcó tanto el análisis como el diseño, la implementación y el ajuste funcional del sistema.

### Levantamiento y análisis de requisitos

- Participé en la identificación de necesidades del sistema.
- Ayudé a definir los requerimientos funcionales y la lógica de los roles.
- Colaboré en la definición de los flujos principales para estudiantes y propietarios.

### Diseño y construcción de la base de datos

- Participé en el modelado de entidades y relaciones.
- Apoyé la creación de la estructura de la base de datos.
- Trabajé en la implementación de migraciones para reflejar el diseño lógico del sistema.

### Desarrollo backend

- Implementé lógica del servidor usando Laravel.
- Trabajé en controladores, modelos, validaciones, middleware y rutas.
- Participé en la gestión de autenticación, reservas, favoritos y administración de habitaciones.

### Desarrollo frontend

- Participé en la construcción de interfaces con Blade, Tailwind CSS y recursos de frontend del proyecto.
- Apoyé el diseño y desarrollo de vistas para estudiantes y propietarios.
- Trabajé en formularios, navegación, listados, vistas de detalle y flujos de interacción del usuario.

### Integración y pruebas funcionales

- Colaboré en la conexión entre frontend, backend y base de datos.
- Realicé validaciones funcionales de los flujos principales del sistema.
- Apoyé la corrección de errores y ajustes durante el proceso de desarrollo.

En resumen, participé de manera integral en el proyecto: desde la obtención de requisitos, el diseño de la base de datos y la estructura del sistema, hasta el desarrollo frontend, backend, integración y puesta en funcionamiento de la aplicación.

## Instalación y ejecución local

1. Clonar el repositorio.
2. Instalar dependencias de PHP:

```bash
composer install
```

3. Instalar dependencias de frontend:

```bash
npm install
```

4. Crear el archivo de entorno:

```bash
copy .env.example .env
```

5. Generar la clave de Laravel:

```bash
php artisan key:generate
```

6. Configurar la base de datos en `.env`.
7. Ejecutar migraciones:

```bash
php artisan migrate
```

8. Compilar assets:

```bash
npm run build
```

9. Iniciar el servidor:

```bash
php artisan serve
```

## Consideraciones

- El proyecto usa integración con `Cloudinary` para el manejo de imágenes.
- Algunas vistas y flujos están orientados específicamente a estudiantes y propietarios mediante middleware y control de roles.
- El sistema está pensado como una solución académica o de portafolio enfocada en alojamiento universitario.

## Estado actual

El proyecto cuenta con una base funcional que cubre autenticación, publicación de habitaciones, búsqueda, favoritos y solicitudes de reserva, sirviendo como evidencia del desarrollo completo de una aplicación web con responsabilidades tanto de análisis como de implementación.
