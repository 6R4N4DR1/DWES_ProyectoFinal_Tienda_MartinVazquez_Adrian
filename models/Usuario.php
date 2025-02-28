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
        private ?string $password;
        private ?string $rol;
        private BaseDatos $bd;

        // Getters y Setters

        /**
         * Obtiene el ID del usuario.
         * 
         * @return int ID del usuario.
         */
        public function getId(){
            return $this->id;
        }

        /**
         * Establece el ID del usuario.
         * 
         * @param int $id ID del usuario.
         */
        public function setId(int $id){
            $this->id = $id;
        }

        /**
         * Obtiene el nombre del usuario.
         * 
         * @return string Nombre del usuario.
         */
        public function getNombre(){
            return $this->nombre;
        }

        /**
         * Establece el nombre del usuario.
         * 
         * @param string $nombre Nombre del usuario.
         */
        public function setNombre(string $nombre){
            $this->nombre = $nombre;
        }

        /**
         * Obtiene los apellidos del usuario.
         * 
         * @return string Apellidos del usuario.
         */
        public function getApellidos(){
            return $this->apellidos;
        }

        /**
         * Establece los apellidos del usuario.
         * 
         * @param string $apellidos Apellidos del usuario.
         */
        public function setApellidos(string $apellidos){
            $this->apellidos = $apellidos;
        }

        /**
         * Obtiene el email del usuario.
         * 
         * @return string Email del usuario.
         */
        public function getEmail(){
            return $this->email;
        }

        /**
         * Establece el email del usuario.
         * 
         * @param string $email Email del usuario.
         */
        public function setEmail(string $email){
            $this->email = $email;
        }

        /**
         * Obtiene la contraseña del usuario.
         * 
         * @return string Contraseña del usuario.
         */
        public function getPassword(){
            return $this->password;
        }

        /**
         * Establece la contraseña del usuario.
         * 
         * @param string $password Contraseña del usuario.
         */
        public function setPassword(?string $password){
            $this->password = $password;
        }

        /**
         * Obtiene el rol del usuario.
         * 
         * @return string Rol del usuario.
         */
        public function getRol(){
            return $this->rol;
        }

        /**
         * Establece el rol del usuario.
         * 
         * @param string $rol Rol del usuario.
         */
        public function setRol(?string $rol){
            $this->rol = $rol;
        }

        /**
         * Guarda un nuevo usuario en la base de datos.
         * 
         * @return bool True si el usuario se guardó correctamente, false en caso contrario.
         */
        public function guardar(){
            // Instancia la conexión a la base de datos
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
            // Instancia la conexión a la base de datos
            $this->bd = new BaseDatos();
            $sql = "SELECT * FROM usuarios WHERE email = :email";
            $this->bd->ejecutarConsulta($sql, [':email' => $this->email]);

            if($this->bd->getNumRegistros() == 1){
                $usuario = $this->bd->getNextRegistro();
                
                $verify = password_verify($this->password, $usuario['password']);
                if($verify){
                    $this->setId($usuario['id']);
                    $this->setNombre($usuario['nombre']);
                    $this->setApellidos($usuario['apellidos']);
                    $this->setEmail($usuario['email']);
                    $this->setRol($usuario['rol']);
                    $this->bd->closeBD();

                    return $this;
                }
            }
            $this->bd->closeBD();

            return null;
        }

        /**
         * Actualiza los datos de un usuario en la base de datos.
         * 
         * @return bool True si los datos se actualizaron correctamente, false en caso contrario.
         */
        public function actualizarBD(){
            // Instancia la conexión a la base de datos
            $this->bd = new BaseDatos();

            if(!$this->password || strlen($this->password) == 0){
                $this->password = null;
            }

            if(!isset($this->rol)){
                $this->rol = 'user';
            }

            if($this->password !== null){
                $sql = "UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, email = :email, password = :password, rol = :rol WHERE id = :id";
                $this->bd->ejecutarConsulta($sql, [
                    ':nombre' => $this->nombre,
                    ':apellidos' => $this->apellidos,
                    ':email' => $this->email,
                    ':password' => Utils::cifrarPassword($this->password),
                    ':rol' => $this->rol,
                    ':id' => $this->id
                ]);
            }else{
                $sql = "UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, email = :email, rol = :rol WHERE id = :id";
                $this->bd->ejecutarConsulta($sql, [
                    ':nombre' => $this->nombre,
                    ':apellidos' => $this->apellidos,
                    ':email' => $this->email,
                    ':rol' => $this->rol,
                    ':id' => $this->id
                ]);
            }

            $salidaBD = $this->bd->getNumRegistros() == 1;
            $this->bd->closeBD();
            
            return $salidaBD;
        }

        /**
         * Verifica si el email ya existe en la base de datos.
         * 
         * @return bool True si el email existe, false en caso contrario.
         */
        public function existeEmail(){
            // Instancia la conexión a la base de datos
            $this->bd = new BaseDatos();
            $sql = "SELECT id FROM usuarios WHERE email = :email";
            $this->bd->ejecutarConsulta($sql, [':email' => $this->email]);

            $existe = $this->bd->getNumRegistros() > 0;
            $this->bd->closeBD();

            return $existe;
        }

        /**
         * Obtiene un usuario por su email.
         * 
         * @param string $email Email del usuario.
         * @return ?Usuario El usuario si se encontró, null en caso contrario.
         */
        public static function getUserPorEmail(string $email){
            // Instancia la conexión a la base de datos
            $bdClon = new BaseDatos();
            $sql = "SELECT * FROM usuarios WHERE email = :email";
            $bdClon->ejecutarConsulta($sql, [':email' => $email]);

            if($bdClon->getNumRegistros() == 1){
                $registro = $bdClon->getNextRegistro();

                $usuario = new Usuario();
                $usuario->setId($registro['id']);
                $usuario->setNombre($registro['nombre']);
                $usuario->setApellidos($registro['apellidos']);
                $usuario->setEmail($registro['email']);
                $usuario->setRol($registro['rol']);
                $bdClon->closeBD();

                return $usuario;
            }
            $bdClon->closeBD();

            return null;
        }

        /**
         * Obtiene todos los usuarios de la base de datos ordenados por ID.
         * 
         * @return array Lista de usuarios.
         */
        public static function getAllUsers(){
            // Instancia la conexión a la base de datos
            $bdClon = new BaseDatos();
            $sql = "SELECT * FROM usuarios";
            $bdClon->ejecutarConsulta($sql);
            $registros = $bdClon->getRegistros();
            $usuarios = [];

            foreach($registros as $registro){
                $usuario = new Usuario();
                $usuario->setId($registro['id']);
                $usuario->setNombre($registro['nombre']);
                $usuario->setApellidos($registro['apellidos']);
                $usuario->setEmail($registro['email']);
                $usuario->setRol($registro['rol']);
                $usuarios[] = $usuario;
            }
            $bdClon->closeBD();

            return $usuarios;
        }

        /**
         * Obtiene un usuario por su ID.
         * 
         * @param int $id ID del usuario.
         * @return ?Usuario El usuario si se encontró, null en caso contrario.
         */
        public static function getUserPorId(int $id){
            // Instancia la conexión a la base de datos
            $bdClon = new BaseDatos();
            $sql = "SELECT * FROM usuarios WHERE id = :id";
            $bdClon->ejecutarConsulta($sql, [':id' => $id]);

            if($bdClon->getNumRegistros() == 1){
                $registro = $bdClon->getNextRegistro();

                $usuario = new Usuario();
                $usuario->setId($registro['id']);
                $usuario->setNombre($registro['nombre']);
                $usuario->setApellidos($registro['apellidos']);
                $usuario->setEmail($registro['email']);
                $usuario->setRol($registro['rol']);
                $bdClon->closeBD();

                return $usuario;
            }
            $bdClon->closeBD();

            return null;
        }
    }
?>