<?php
    namespace helpers;

    /**
     * Clase Utils
     * Clase de utilidades con métodos estáticos para diversas funciones comunes.
     */
    class Utils{
        
        /**
         * Método deleteSession
         * Elimina una sesión específica.
         * 
         * @param string $name Nombre de la sesión a eliminar.
         */
        public static function deleteSession($name){
            if(isset($_SESSION[$name])){
                $_SESSION[$name] = null;
                unset($_SESSION[$name]);
            }
        }

        /**
         * Método cifrarPassword
         * Cifra una contraseña utilizando el algoritmo BCRYPT.
         * 
         * @param string $password Contraseña a cifrar.
         * @return string Contraseña cifrada.
         */
        public static function cifrarPassword($password){
            return password_hash($password, PASSWORD_BCRYPT, ['cost' => 4]);
        }

        /**
         * Método isNotIdentity
         * Comprueba si el usuario está registrado (identificado).
         * Si no está registrado, redirige a la página principal.
         */
        public static function isNotIdentity(){
            if(!isset($_SESSION['identity'])){
                header('Location:'.BASE_URL);
            }
        }

        /**
         * Método isIdentity
         * Comprueba si el usuario está registrado (identificado).
         * Si está registrado, redirige a la página principal.
         */
        public static function isIdentity(){
            if(isset($_SESSION['identity'])){
                header('Location:'.BASE_URL);
            }
        }

        /**
         * Método isAdmin
         * Comprueba si el usuario es administrador.
         * Si no es administrador, redirige a la página principal.
         */
        public static function isAdmin(){
            if(!isset($_SESSION['identity']) || $_SESSION['identity']['rol'] !== 'admin'){
                header('Location:'.BASE_URL);
            }
        }
    }
?>