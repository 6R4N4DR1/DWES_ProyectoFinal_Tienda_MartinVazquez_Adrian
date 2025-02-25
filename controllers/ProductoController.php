<?php
    namespace controllers;

    class ProductoController{
        public function destacados(){
            require_once 'views/producto/destacados.php';
        }

        public function categoria(){
            echo "Controlador Producto, acción categoria";
        }

        public function ver(){
            echo "Controlador Producto, acción ver";
        }
    }
?>