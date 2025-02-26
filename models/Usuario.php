<?php
    namespace models;

    use lib\BaseDatos;
    use helpers\Utils;

    class Usuario{
        private int $id;
        private string $nombre;
        private string $apellidos;
        private string $email;
        private string $password;
        private string $rol;
        private BaseDatos $baseDatos;

        public function __construct(){
            $this->baseDatos = new BaseDatos();
        }

        //Getter y Setters
        public function getId(): int{
            return $this->id;
        }

        public function setId(int $id): void{
            $this->id = $id;
        }

        public function getNombre(): string{
            return $this->nombre;
        }

        public function setNombre(string $nombre): void{
            $this->nombre = $nombre;
        }

        public function getApellidos(): string{
            return $this->apellidos;
        }

        public function setApellidos(string $apellidos): void{
            $this->apellidos = $apellidos;
        }

        public function getEmail(): string{
            return $this->email;
        }

        public function setEmail(string $email): void{
            $this->email = $email;
        }

        public function getPassword(): string{
            return $this->password;
        }

        public function setPassword(string $password): void{
            $this->password = $password;
        }

        public function getRol(): string{
            return $this->rol;
        }

        public function setRol(string $rol): void{
            $this->rol = $rol;
        }

        public function guardar(){
            $consultaSQL = "INSERT INTO usuarios VALUES(null, :nombre, :apellidos, :email, :password, :rol)";
            $this->baseDatos->ejecutarConsulta($consultaSQL, [
                ':nombre' => $this->nombre,
                ':apellidos' => $this->apellidos,
                ':email' => $this->email,
                ':password' => Utils::cifrarPassword($this->password),
                ':rol' => $this->rol
            ]);

            return $this->baseDatos->getNumeroRegistros() == 1;
        }

        public function login(){
            $resultado = false;
            $email = $this->email;
            $password = $this->password;

            $consultaSQL = "SELECT id, password FROM usuarios WHERE email = '$email'";
            $this->baseDatos->ejecutarConsulta($consultaSQL, [':email' => $email]);

            if($this->baseDatos->getNumeroRegistros() == 1){
                $usuario = $this->baseDatos->getNextRegistro();

                $verify = password_verify($password, $usuario['password']);
                if($verify){
                    $resultado = $usuario;
                }
            }
            return $resultado;
        }

        
    }
?>