# Explicación MVC y Lógica de Vistas

Este documento explica cómo el prototipo estático (Front-end) se conectará con la arquitectura MVC (Model-View-Controller) del Backend.

## Correspondencia Prototipo vs MVC

El prototipo estático `prototype/index.html` representa lo que el usuario ve finalmente en su navegador, pero en el servidor esta página se construye dinámicamente combinando varias piezas.

### 1. Layouts (Base Estructural)
En lugar de repetir el código HTML en cada página, utilizaremos un sistema de "Layouts".
*   **Header y Footer**: Se extraen a archivos separados (`views/layout/header.php`, `views/layout/footer.php`).
*   **Contenido Dinámico**: El "cuerpo" de la página se inyecta entre el header y el footer dependiendo de la acción del controlador.

### 2. Vistas (Views)
La sección central del prototipo corresponde a las Vistas específicas:
*   La sección "Hero" y "Listado de Posts" del prototipo se convertirá en `views/posts/index.php`.
*   El detalle de un post (imaginado en el mapa de navegación) será `views/posts/show.php`.

### 3. Datos Dinámicos (Modelos y Controladores)
En el prototipo HTML, los títulos, imágenes y textos están "hardcodeados" (escritos fijos). En la aplicación real:
*   **El Controlador (`PostController`)**: Pide los datos a la base de datos.
*   **El Modelo (`Post`)**: Ejecuta la consulta SQL (`SELECT * FROM posts`).
*   **La Vista**: Recibe un array de datos (`$posts`) y usa un bucle (`foreach`) para generar las tarjetas HTML repetitivas automáticamente.

## Ejemplo de Flujo
1.  Usuario entra a `/`.
2.  Router llama a `PostController` -> `index()`.
3.  `index()` llama al modelo para obtener los últimos 5 libros.
4.  `index()` carga `header.php`.
5.  `index()` carga `views/posts/index.php` pasándole los datos de los libros.
6.  `views/posts/index.php` recorre los libros y crea las tarjetas HTML.
7.  `index()` carga `footer.php`.
8.  El servidor envía el HTML completo al navegador.
