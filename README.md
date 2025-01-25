# Gestión de Equipos

Este proyecto es una aplicación web para gestionar equipos, jugadores e instalaciones utilizando PHP, Doctrine ORM y Bootstrap para el diseño de la interfaz de usuario.

## Requisitos

- PHP 7.4 o superior
- Composer
- MySQL
- XAMPP (opcional, para un entorno de desarrollo local)

## Instalación

1. Clona el repositorio en tu máquina local:
    ```sh
    git clone https://github.com/tu-usuario/SymfonyEquipo.git
    ```

2. Navega al directorio del proyecto:
    ```sh
    cd SymfonyEquipo
    ```

3. Instala las dependencias de Composer:
    ```sh
    composer install
    ```

4. Configura la conexión a la base de datos en el archivo [bootstrap.php](http://_vscodecontentref_/0):
    ```php
    // bootstrap.php
    $conn = [
        'driver' => 'pdo_mysql',
        'user' => 'tu_usuario',
        'password' => 'tu_contraseña',
        'dbname' => 'nombre_de_tu_base_de_datos',
    ];
    ```

5. Crea las tablas necesarias en la base de datos ejecutando los comandos de Doctrine:
    ```sh
    php vendor/bin/doctrine orm:schema-tool:create
    ```

## Uso

1. Inicia el servidor web (si estás usando XAMPP, asegúrate de que Apache y MySQL estén en ejecución).

2. Abre tu navegador web y navega a `http://localhost/SymfonyEquipo/crud/index.php`.

3. Utiliza la interfaz para gestionar equipos, jugadores e instalaciones.

## Estructura del Proyecto

- [bootstrap.php](http://_vscodecontentref_/1): Configuración de Doctrine ORM.
- [src](http://_vscodecontentref_/2): Contiene las entidades del proyecto (`EquipoBidireccional.php`, `Instalacion.php`, `Jugador.php`).
- [crud](http://_vscodecontentref_/3): Contiene las páginas de gestión (`crear_ver_equipo.php`, `crear_ver_instalaciones.php`, `crear_ver_jugador.php`, `index.php`).

## Archivos Principales

### `index.php`
Página principal con botones para acceder a las páginas de gestión de equipos, jugadores e instalaciones.

### `crear_ver_equipo.php`
Página para crear, ver y gestionar equipos.

### `crear_ver_instalaciones.php`
Página para crear, ver y gestionar instalaciones.

### `crear_ver_jugador.php`
Página para crear, ver y gestionar jugadores.

## Estilo

El proyecto utiliza Bootstrap para el diseño de la interfaz de usuario con un tema oscuro personalizado.

## Contribuciones

Las contribuciones son bienvenidas. Por favor, abre un issue o un pull request para discutir cualquier cambio que desees realizar.
