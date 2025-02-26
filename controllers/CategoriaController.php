<?php
    namespace controllers;

    // Importa los modelos de Categoria y Producto, y las utilidades
    use models\Categoria;
    use models\Producto;
    use helpers\Utils;

    /**
     * Clase CategoriaController
     * Controlador para gestionar las acciones relacionadas con las categorías.
     */
    class CategoriaController{
        
        /**
         * Método index
         * Carga la vista principal de categorías.
         */
        public function index(){
            require_once 'views/categoria/index.php';
        }
    }
?>