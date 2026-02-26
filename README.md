*   **Bases de Datos más modernas:** En lugar de crear las tablas de usuarios, posts y comentarios a mano o con archivos SQL que se pierden, ahora uso algo llamado **Migraciones**. Es código que crea automáticamente la misma base de datos estés donde estés.
*   **Dejé atrás el HTML repetitivo:** Convertí las páginas antiguas al sistema de vistas que usa Laravel (Blade). Esto me ha permitido separar la estructura y dejar de copiar y pegar los menús de navegación en cada archivo.
*   **Tráfico controlado (Rutas y Controladores):** Antes los archivos decidían por sí mismos qué mostrar. Ahora he configurado unas "Rutas" que detectan a dónde intenta ir el usuario y envían esa petición a los "Controladores" (como el `AdminController`), que devuelven exactamente la información que se necesita, como estadísticas o listas de usuarios.


