<?php
    namespace controllers;

    class UsuarioController{
        public function register(){
            require_once 'views/usuario/registro.php';
        }

        public function save(){
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