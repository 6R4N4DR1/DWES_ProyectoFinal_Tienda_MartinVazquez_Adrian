<?php
    namespace helpers;

    class Utils{
        public static function deleteSession($name){
            if(isset($_SESSION[$name])){
                $_SESSION[$name] = null;
                unset($_SESSION[$name]);
            }
        }

        public static function cifrarPassword($password){
            return password_hash($password, PASSWORD_BCRYPT, ['cost' => 4]);
        }

        //Funcion para comprobar si el usuario está registrado ya
        public static function isIdentity(){
            if(!isset($_SESSION['identity'])){
                header('Location:'.BASE_URL);
            }
        }

        //Funcion para comprobar si el usuario es admin
        public static function isAdmin(){
            if(!isset($_SESSION['identity']) || $_SESSION['identity']['rol'] !== 'admin'){
                header('Location:'.BASE_URL);
            }
        }

    }
?>