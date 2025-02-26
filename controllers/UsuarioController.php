<?php
    namespace controllers;

    use models\Usuario;
    use helpers\Utils;

    class UsuarioController{
        public function register(){
            require_once 'views/usuario/registro.php';
        }

        public function save(){
            Utils::isIdentity();

            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
                $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : false;
                $email = isset($_POST['email']) ? $_POST['email'] : false;
                $password = isset($_POST['password']) ? $_POST['password'] : false;
                $rol = isset($_POST['rol']) ? $_POST['rol'] : 'user';

                $_SESSION['form_data'] = [
                    'nombre' => $nombre,
                    'apellidos' => $apellidos,
                    'email' => $email,
                    'password' => $password,
                    'rol' => $rol
                ];

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
                            header("Location:" . BASE_URL . "usuario/admin" . (isset($_SESSION['pag']) ? "&pag=" . $_SESSION['pag'] : ""));
                        }else{
                            header("Location:" . BASE_URL . "usuario/register");
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

        public function login(){
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $email = isset($_POST['email']) ? $_POST['email'] : false;
                $password = isset($_POST['password']) ? $_POST['password'] : false;
                $recuerdame = isset($_POST['recuerdame']);

                $_SESSION['form_data'] = [
                    'email' => $email,
                    'password' => $password,
                    'recuerdame' => $recuerdame
                ];

                if($email && $password){
                    $usuario = new Usuario();
                    $usuario->setEmail($email);
                    $usuario->setPassword($password);
                    $usuario = $usuario->login();

                    if($usuario){
                        Utils::deleteSession('form_data');

                        $_SESSION['identity'] = [
                            'id' => $usuario->getId(),
                            'nombre' => $usuario->getNombre(),
                            'apellidos' => $usuario->getApellidos(),
                            'email' => $usuario->getEmail(),
                            'rol' => $usuario->getRol()
                        ];

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