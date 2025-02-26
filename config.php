<?php
    // Configuración de la base de datos
    define('DB_HOST', 'localhost'); // Host de la base de datos
    define('DB_USER', 'root'); // Usuario de la base de datos
    define('DB_PASS', ''); // Contraseña de la base de datos
    define('DB_NAME', 'tienda'); // Nombre de la base de datos

    // Configuración del controlador y acción por defecto
    define('CONTROLLER_DEFAULT', 'Producto'); // Controlador por defecto - Página por defecto
    define('ACTION_DEFAULT', 'destacados'); // Acción de la página o controlador por defecto

    // URL base del proyecto
    define('BASE_URL', 'http://localhost/dashboard/DWES_ProyectoFinal_Tienda_MartinVazquez_Adrian/');

    /**
     * Nota:
     * No se ha utilizado Composer para la configuración de la base de datos desde el archivo .env
     * porque modificar archivos internos de XAMPP y su configuración SSL podría romper el servidor XAMPP.
     * Para evitar problemas y mantener la estabilidad del servidor, he optado por definir las constantes
     * de configuración directamente en este archivo.
     */
?>