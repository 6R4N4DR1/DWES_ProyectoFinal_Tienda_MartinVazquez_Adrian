<?php
    namespace controllers;

    // Importa los modelos de Pedido y Producto, y las utilidades
    use models\Pedido;
    use models\Producto;
    use helpers\Utils;

    /**
     * Clase PedidoController
     * Controlador para gestionar las acciones relacionadas con los pedidos.
     */
    class PedidoController{
        
        /**
         * Método index
         * Carga la vista principal de pedidos.
         */
        public function index(){
            require_once 'views/pedido/index.php';
        }
    }
?>