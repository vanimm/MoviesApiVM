# API Movies

Este proyecto trata sobre Películas y sus géneros, las cuales se consume de una API de movies "themoviedb".
Se obtiene la lista de películas y se almacena en la base de datos, para luego poder actualizar o eliminar información de la BD. 


### Requisitos del Sistema
- PHP >= 7.4
- Composer
- MySQL 5.7 o superior, o cualquier otro sistema de gestión de bases de datos compatible con Laravel

### Configuración del Entorno Local

1. Clonar el repositorio:
   -    git clone https://github.com/vanimm/MoviesApiVM.git
2.  Acceder al directorio del proyecto 
    -   cd proyecto
3. Copiar el archivo de entorno y configura las variables
    -   cp .env.example .env
4. Intalar las dependencias de composer
    -   composer install
5. Genera la clave de la aplicación
    -   php artisan key:generate
6. Configurar las conexiones con la base de datos en el archivo de entorno ".env"
7. Ejecutar las migraciones
    -   php artisan migrate
8. Iniciar el servidor
    -   php artisan serve

### Base de Datos
La BD está en MySQL, Creamos la BD y luego configuramos el archivo .env para conectar y poder hacer las migraciones. 
 
### API y Rutas
- En el archivo de entorno ".env", existen dos variables donde vamos a configurar para acceder a la API de movies y vamos a colocar nuestro token que nos proporciona la web

    - API_ENDPOINT=https://api.themoviedb.org/3/
    - API_KEY = 

- Para conectar con la API utilice Guzzlehttp
    -   previamente lo instalé el paquete de Guzzle, Laravel ya lo incluye automaticamente, sin embargo para asegurarse lo instalé.

        "composer require guzzlehttp/guzzle"

- Rutas
    *   GET / - Muestra la página principal, donde podemos ver el listado de de películas
    *   GET /movies/{id} - Muestra página para editar la película seleccionada por id.
    *   DELETE /movies/{id} - Elimina un registro de la BD. 
    *   PUT /movies/{id} - Actualiza los datos de la movie seleccionada y redirecciona a la página principal
    *   GET /api - Hace una petición a la API y carga las movies nuevas en la BD