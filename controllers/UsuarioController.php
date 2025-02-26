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
                        header("Location:" . BASE_URL . "usuario/register");
                    }else{
                        $_SESSION['register'] = 'failed';
                        header('Location:'.BASE_URL.'usuario/register');
                        exit();
                    }
                }else{
                    $_SESSION['register'] = 'failed';
                    header('Location:'.BASE_URL.'usuario/register');
                    exit();
                }
            }else{
                header('Location:'.BASE_URL);
                exit();
            }
        }

        public function login(){
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                $usuario = new Usuario();
                $usuario->setEmail($_POST['email']);
                $usuario->setPassword($_POST['password']);
                $identity = $usuario->login();

                $_SESSION['form_data'] = [
                    'email' => $usuario->getEmail(),
                    'password' => $usuario->getPassword()
                ];

                if($identity && is_object($identity)){
                    $_SESSION['identity'] = $identity;

                    if($identity->rol === 'admin'){
                        $_SESSION['admin'] = true;
                    }
                }else{
                    $_SESSION['error_login'] = 'Identificación fallida';
                }
            }else{
                header('Location:'.BASE_URL);
                exit();
            }
        }

        public function logout(){
            if(isset($_SESSION['identity'])){
                unset($_SESSION['identity']);
            }

            if(isset($_SESSION['admin'])){
                unset($_SESSION['admin']);
            }
        }
    }
?>