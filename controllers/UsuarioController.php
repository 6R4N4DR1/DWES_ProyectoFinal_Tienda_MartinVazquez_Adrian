<?php
    namespace controllers;

    class UsuarioController{
        public function registro(){
            require_once 'views/usuario/registro.php';
        }

        public function guardar(){
            if(isset($_POST)){
                //Guardar en la base de datos
            }
        }

        public function login(){
            echo "Controlador Usuario, acción login";
        }

        public function logout(){
            echo "Controlador Usuario, acción logout";
        }
    }
?>