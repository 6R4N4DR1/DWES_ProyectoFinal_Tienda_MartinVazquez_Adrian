<?php
    namespace controllers;

    use models\Usuario;
    use helpers\Utils;

    class UsuarioController{
        public function register(){
            require_once 'views/usuario/registro.php';
        }

        public function save(){
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : false;
                $apellidos = isset($_POST['apellidos']) ? trim($_POST['apellidos']) : false;
                $email = isset($_POST['email']) ? trim($_POST['email']) : false;
                $password = isset($_POST['password']) ? trim($_POST['password']) : false;
                $rol = isset($_POST['rol']) ? $_POST['rol'] : 'user';
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