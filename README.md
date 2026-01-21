# Blog de Libros - Informe personal

## Lo que hice
- Creé la carpeta `app/`  Ese archivo inicia la sesión, carga la configuración, abre la conexión PDO y envía la petición al controlador y acción correctos.
- Quité el `index.php` que estaba en la raíz. Ya no se usa.
- Cambié el `Dockerfile` para que Apache cargue por defecto `app/index.php` con `DirectoryIndex`. Así, el contenedor apunta directo al front controller dentro de `app/`.
- Revisé la estructura existente: las carpetas `controllers/`, `models/`, `views/`, `public/` y `config/` ya estaban bien organizadas. No tuve que mover más cosas.
- Verifiqué que las rutas principales siguen funcionando: inicio, detalle de post, login y registro. Los comentarios y el sistema de roles (admin, writer, subscriber) siguen igual.
- Intenté ejecutar `git add README.md`, pero el sistema no me dejó crear el lock `.git/index.lock` por un tema de permisos. No toqué nada más relacionado con git.

## Estructura actual
- `app/index.php`: punto de entrada que resuelve controladores y acciones.
- `config/`: configuración general y conexión PDO (`config.php`, `Database.php`).
- `controllers/`: lógica de posts, usuarios, comentarios, admin y RAG.
- `models/`: acceso a datos para `Post`, `User`, `Comment`, `Category`.
- `views/`: vistas de inicio, detalle, auth, admin, etc., con encabezado y pie comunes.
- `public/`: CSS generado y assets. Tailwind se usa desde CDN en las vistas.
- `database.sql`: crea la base de datos MySQL con tablas y un usuario admin de ejemplo.
- `Dockerfile` y `docker-compose.yml`: definen los servicios PHP/Apache, MySQL, phpMyAdmin y n8n para webhooks.

## Cómo arrancar
1) Tener Docker y Docker Compose instalados.  
2) En la raíz del proyecto: `docker compose up --build` (usa `-d` si quieres modo daemon).  
3) La app queda en `http://localhost:8080`. phpMyAdmin en `http://localhost:8081`. n8n en `http://localhost:5678`.  
4) La base de datos se llena con `database.sql` la primera vez. Usuario admin: `admin@example.com`, password `password`.  

## Roles y permisos
- `admin`: puede todo, incluido acceder al panel admin y borrar contenido.
- `writer`: puede crear y editar sus posts.
- `subscriber`: puede leer y comentar.

## Webhooks y n8n
Los eventos de creación y borrado de comentarios y creación de posts se envían a `N8N_WEBHOOK_URL` con el token `N8N_WEBHOOK_TOKEN`. Las variables vienen de `config/config.php` y se pueden cambiar por entorno en `docker-compose.yml`.

