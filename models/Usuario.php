<?php
    namespace models;

    use lib\BaseDatos;
    use helpers\Utils;

    /**
     * Clase Usuario
     * Modelo para gestionar las operaciones relacionadas con los usuarios.
     */
    class Usuario{
        private int $id;
        private string $nombre;
        private string $apellidos;
        private string $email;
        private string $password;
        private string $rol;
        private BaseDatos $bd;


        // Getters y Setters

        /**
         * Obtiene el ID del usuario.
         * 
         * @return int ID del usuario.
         */
        public function getId(): int{
            return $this->id;
        }

        /**
         * Establece el ID del usuario.
         * 
         * @param int $id ID del usuario.
         */
        public function setId(int $id): void{
            $this->id = $id;
        }

        /**
         * Obtiene el nombre del usuario.
         * 
         * @return string Nombre del usuario.
         */
        public function getNombre(): string{
            return $this->nombre;
        }

        /**
         * Establece el nombre del usuario.
         * 
         * @param string $nombre Nombre del usuario.
         */
        public function setNombre(string $nombre): void{
            $this->nombre = $nombre;
        }

        /**
         * Obtiene los apellidos del usuario.
         * 
         * @return string Apellidos del usuario.
         */
        public function getApellidos(): string{
            return $this->apellidos;
        }

        /**
         * Establece los apellidos del usuario.
         * 
         * @param string $apellidos Apellidos del usuario.
         */
        public function setApellidos(string $apellidos): void{
            $this->apellidos = $apellidos;
        }

        /**
         * Obtiene el email del usuario.
         * 
         * @return string Email del usuario.
         */
        public function getEmail(): string{
            return $this->email;
        }

        /**
         * Establece el email del usuario.
         * 
         * @param string $email Email del usuario.
         */
        public function setEmail(string $email): void{
            $this->email = $email;
        }

        /**
         * Obtiene la contraseña del usuario.
         * 
         * @return string Contraseña del usuario.
         */
        public function getPassword(): string{
            return $this->password;
        }

        /**
         * Establece la contraseña del usuario.
         * 
         * @param string $password Contraseña del usuario.
         */
        public function setPassword(string $password): void{
            $this->password = $password;
        }

        /**
         * Obtiene el rol del usuario.
         * 
         * @return string Rol del usuario.
         */
        public function getRol(): string{
            return $this->rol;
        }

        /**
         * Establece el rol del usuario.
         * 
         * @param string $rol Rol del usuario.
         */
        public function setRol(string $rol): void{
            $this->rol = $rol;
        }

        /**
         * Guarda un nuevo usuario en la base de datos.
         * 
         * @return bool True si el usuario se guardó correctamente, false en caso contrario.
         */
        public function guardar(): bool{
            $this->bd = new BaseDatos();
            $sql = "INSERT INTO usuarios VALUES(null, :nombre, :apellidos, :email, :password, :rol)";
            $this->bd->ejecutarConsulta($sql, [
                ':nombre' => $this->nombre,
                ':apellidos' => $this->apellidos,
                ':email' => $this->email,
                ':password' => Utils::cifrarPassword($this->password),
                ':rol' => $this->rol
            ]);

            $salidaBD = $this->bd->getNumRegistros() == 1;
            $this->bd->closeBD();
            return $salidaBD;
        }

        /**
         * Gestiona el inicio de sesión de un usuario.
         * 
         * @return ?Usuario El usuario si el inicio de sesión fue exitoso, null en caso contrario.
         */
        public function login(){
            $this->bd->ejecutarConsulta("SELECT * FROM usuarios WHERE email = :email", [
                ':email' => $this->email
            ]);

            if($this->bd->getNumRegistros() == 1){
                $usuario = $this->bd->getNextRegistro();
                
                $verify = password_verify($this->password, $usuario['password']);
                if($verify){
                    $this->setId($usuario['id']);
                    $this->setNombre($usuario['nombre']);
                    $this->setApellidos($usuario['apellidos']);
                    $this->setEmail($usuario['email']);
                    $this->setRol($usuario['rol']);
                    return $this;
                }
            }
            return null;
        }

        /**
         * Obtiene un usuario por su email.
         * 
         * @param string $email Email del usuario.
         * @return ?Usuario El usuario si se encontró, null en caso contrario.
         */
        public static function getUserPorEmail(string $email): ?Usuario {
            $baseDatos = new BaseDatos();
            $consultaSQL = "SELECT * FROM usuarios WHERE email = :email";
            $baseDatos->ejecutarConsulta($consultaSQL, [
                ':email' => $email
            ]);

            if($baseDatos->getNumeroRegistros() == 1){
                $registro = $baseDatos->getNextRegistro();

                $usuario = new Usuario();
                $usuario->setId($registro['id']);
                $usuario->setNombre($registro['nombre']);
                $usuario->setApellidos($registro['apellidos']);
                $usuario->setEmail($registro['email']);
                $usuario->setRol($registro['rol']);
                return $usuario;
            }
            return null;
        }
    }
?>