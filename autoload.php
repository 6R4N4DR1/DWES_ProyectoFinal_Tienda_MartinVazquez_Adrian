<?php
    /**
     * Función controllers_autoload
     * Autocarga las clases de los controladores y modelos.
     * 
     * @param string $classname Nombre de la clase a cargar.
     */
    function controllers_autoload($classname){
        // Reemplaza las barras invertidas por barras normales en el nombre de la clase
        $classname = str_replace("\\", "/", $classname);
        // Construye la ruta completa del archivo de la clase
        $file = __DIR__ . '/' . $classname . '.php';
        // Si el archivo existe, lo requiere
        if (file_exists($file)) require_once $file;
    }

    // Registra la función de autocarga
    spl_autoload_register('controllers_autoload');

    /**
     * Nota:
     * Este autoload fue creado manualmente con la ayuda de compañeros y GitHub Copilot porque Composer no generaba el autoload correcto que necesitaba y no sabía cómo usarlo correctamente sin que me diera errores.
     */
?>