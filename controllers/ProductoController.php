<?php
    namespace controllers;

    // Importa las utilidades y los modelos de Producto y Categoria
    use helpers\Utils;
    use models\Producto;
    use models\Categoria;

    /**
     * Clase ProductoController
     * Controlador para gestionar las acciones relacionadas con los productos.
     */
    class ProductoController{
        
        /**
         * Método destacados
         * Carga la vista de productos destacados.
         */
        public function destacados(){
            require_once 'views/producto/destacados.php';
        }

        /**
         * Método categoria
         * Carga la vista de productos por categoría.
         */
        public function categoria(){
            require_once 'views/producto/categoria.php';
        }

        /**
         * Método details
         * Carga la vista de detalles de un producto.
         */
        public function details(){
            require_once 'views/producto/detalles.php';
        }
    }
?>