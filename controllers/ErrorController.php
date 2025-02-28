<?php
    namespace controllers;

    /**
     * Clase ErrorController
     * Controlador para gestionar las acciones relacionadas con los errores.
     */
    class ErrorController{
        
        /**
         * Método index
         * Muestra un mensaje de error cuando se intenta acceder a una página que no existe.
         */
        public function index(): void{
            // Muestra un mensaje de error personalizado
            echo "<h1>Deja de buscar p&aacute;ginas que no existen, que est&aacute;s m&aacute;s perdio que una vaca buscando bellotas.</h1>";
            // Muestra un enlace para volver a la página de inicio
            echo '<a href="' . BASE_URL . '" class="boton boton-volver">Ir al inicio</a>';
        }
    }
?>