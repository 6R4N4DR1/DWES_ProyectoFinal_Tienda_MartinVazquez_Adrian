<?php
    namespace controllers;

    // Importa el modelo de Usuario y las utilidades
    use models\Usuario;
    use helpers\Utils;

    /**
     * Clase UsuarioController
     * Controlador para gestionar las acciones relacionadas con los usuarios.
     */
    class UsuarioController{
        
        /**
         * Método register
         * Carga la vista de registro de usuario.
         */
        public function register(){
            Utils::isIdentity();
            require_once 'views/usuario/registro.php';
        }

        /**
         * Método save
         * Guarda un nuevo usuario en la base de datos.
         */
        public function save(){
            Utils::isNotIdentity();

            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                // Recoge los datos del formulario
                $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
                $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : false;
                $email = isset($_POST['email']) ? $_POST['email'] : false;
                $password = isset($_POST['password']) ? $_POST['password'] : false;
                $rol = isset($_POST['rol']) ? $_POST['rol'] : 'user';

                // Guarda los datos del formulario en la sesión
                $_SESSION['form_data'] = [
                    'nombre' => $nombre,
                    'apellidos' => $apellidos,
                    'email' => $email,
                    'password' => $password,
                    'rol' => $rol
                ];

                // Validación de los datos del formulario
                if($nombre && $apellidos && $email && $password){
                    if(!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/", $nombre)){
                        $_SESSION['register'] = 'failed_nombre';
                        header('Location:'.BASE_URL.'usuario/register');
                        exit();
                    }

                    if(!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/", $apellidos)){
                        $_SESSION['register'] = 'failed_apellidos';
                        header('Location:'.BASE_URL.'usuario/register');
                        exit();
                    }

                    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                        $_SESSION['register'] = 'failed_email';
                        header('Location:'.BASE_URL.'usuario/register');
                        exit();
                    }

                    if(!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/', $password)){
                        $_SESSION['register'] = 'failed_password';
                        header('Location:'.BASE_URL.'usuario/register');
                        exit();
                    }

                    // Crea un nuevo usuario y guarda los datos en la base de datos
                    $usuario = new Usuario();
                    $usuario->setNombre($nombre);
                    $usuario->setApellidos($apellidos);
                    $usuario->setEmail($email);
                    $usuario->setPassword(($password));
                    $usuario->setRol($rol);

                    if($usuario->guardar()){
                        Utils::deleteSession('form_data');
                        $_SESSION['register'] = 'complete';
                        if(isset($_SESSION['admin'])){
                            Utils::deleteSession('register');
                            header('Location:' . BASE_URL . 'usuario/admin' . (isset($_SESSION['pag']) ? '&pag=' . $_SESSION['pag'] : ""));
                        }else{
                            header('Location:' . BASE_URL . 'usuario/register');
                        }
                    }else{
                        $_SESSION['register'] = 'failed';
                        header('Location:'.BASE_URL.'usuario/'.(isset($_SESSION['admin']) ? 'crearUsuario' : 'register'));
                        exit();
                    }
                }else{
                    $_SESSION['register'] = 'failed';
                    header('Location:'.BASE_URL.'usuario/'.(isset($_SESSION['admin']) ? 'crearUsuario' : 'register'));
                    exit();
                }
            }else{
                header('Location:'.BASE_URL);
                exit();
            }
        }

        /**
         * Método loginCookies
         * Carga la vista de login y gestiona el inicio de sesión con cookies.
         */
        public function loginCookies(){
            if(isset($_SESSION['identity'])){
                header('Location:'.BASE_URL);
            }

            if(isset($_COOKIE['recuerdame'])){
                $email = $_COOKIE['recuerdame'];
                $usuario = Usuario::getUserPorEmail($email);

                if($usuario){
                    $_SESSION['identity'] = [
                        'id' => $usuario->getId(),
                        'nombre' => $usuario->getNombre(),
                        'apellidos' => $usuario->getApellidos(),
                        'email' => $usuario->getEmail(),
                        'rol' => $usuario->getRol()
                    ];

                    if($usuario->getRol() === 'admin'){
                        $_SESSION['admin'] = true;
                    }

                    header('Location:'.BASE_URL);
                    exit();
                }
            }
            require_once 'views/usuario/login.php';
        }

        /**
         * Método login
         * Gestiona el inicio de sesión de un usuario.
         */
        public function login(){
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                // Recoge los datos del formulario
                $email = isset($_POST['email']) ? $_POST['email'] : false;
                $password = isset($_POST['password']) ? $_POST['password'] : false;
                $recuerdame = isset($_POST['recuerdame']);

                // Guarda los datos del formulario en la sesión
                $_SESSION['form_data'] = [
                    'email' => $email,
                    'password' => $password,
                    'recuerdame' => $recuerdame
                ];

                // Validación de los datos del formulario
                if($email && $password){
                    $usuario = new Usuario();
                    $usuario->setEmail($email);
                    $usuario->setPassword($password);
                    $usuario = $usuario->login();

                    if($usuario){
                        Utils::deleteSession('form_data');

                        // Guarda los datos del usuario en la sesión
                        $_SESSION['identity'] = [
                            'id' => $usuario->getId(),
                            'nombre' => $usuario->getNombre(),
                            'apellidos' => $usuario->getApellidos(),
                            'email' => $usuario->getEmail(),
                            'rol' => $usuario->getRol()
                        ];

                        // Gestiona la cookie de "Recuérdame"
                        if($recuerdame){
                            setcookie('recuerdame', $email, time() + 60*60*24*7);
                        }else{
                            if(isset($_COOKIE['recuerdame'])){
                                setcookie('recuerdame', $email, time() - 1);
                            }
                        }

                        if($usuario->getRol() === 'admin'){
                            $_SESSION['admin'] = true;
                        }

                        header('Location:'.BASE_URL);
                        exit();
                    }else{
                        $_SESSION['login'] = 'failed';
                    }
                }else{
                    $_SESSION['login'] = 'failed';
                }
            }else{
                header('Location:'.BASE_URL);
                exit();
            }
            header('Location:'.BASE_URL."usuario/loginCookies");
            exit();
        }

        /**
         * Método logout
         * Cierra la sesión del usuario.
         */
        public function logout(){
            Utils::isIdentity();
            Utils::deleteSession('identity');
            Utils::deleteSession('admin');

            if(isset($_COOKIE['recuerdame'])){
                setcookie('recuerdame', '', time() - 1);
            }

            header('Location:'.BASE_URL);
        }
    }
?>