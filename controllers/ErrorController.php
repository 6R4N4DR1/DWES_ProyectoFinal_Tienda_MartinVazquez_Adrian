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
            echo "<h1>Deja de buscar p&aacute;ginas que no existen, que est&aacute;s m&aacute;s perdio que una vaca buscando bellotas.</h1>";
        }
    }
?>