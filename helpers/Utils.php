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
            // Verifica si la sesión existe
            if(isset($_SESSION[$name])){
                // Establece la sesión a null y la elimina
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
            // Cifra la contraseña con BCRYPT y un coste de 4
            return password_hash($password, PASSWORD_BCRYPT, ['cost' => 4]);
        }

        /**
         * Método isNotIdentity
         * Comprueba si el usuario está registrado (identificado).
         * Si no está registrado, redirige a la página principal.
         */
        public static function isNotIdentity(){
            // Verifica si la sesión de identidad no está establecida
            if(!isset($_SESSION['identity'])){
                // Redirige a la página principal
                header('Location:'.BASE_URL);
            }
        }

        /**
         * Método isIdentity
         * Comprueba si el usuario está registrado (identificado).
         * Si está registrado, redirige a la página principal.
         */
        public static function isIdentity(){
            // Verifica si la sesión de identidad está establecida
            if(isset($_SESSION['identity'])){
                // Redirige a la página principal
                header('Location:'.BASE_URL);
            }
        }

        /**
         * Método isAdmin
         * Comprueba si el usuario es administrador.
         * Si no es administrador, redirige a la página principal.
         */
        public static function isAdmin(){
            // Verifica si la sesión de identidad no está establecida o si el rol no es 'admin'
            if(!isset($_SESSION['identity']) || $_SESSION['identity']['rol'] !== 'admin'){
                // Redirige a la página principal
                header('Location:'.BASE_URL);
            }
        }
    }
?>