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
                        if(ob_get_length()) { ob_clean(); }
                        header('Location:'.BASE_URL.'usuario/'.(isset($_SESSION['admin']) ? 'crearUsuario' : 'register'));
                        exit();
                    }

                    if(!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/", $apellidos)){
                        $_SESSION['register'] = 'failed_apellidos';
                        if(ob_get_length()) { ob_clean(); }
                        header('Location:'.BASE_URL.'usuario/'.(isset($_SESSION['admin']) ? 'crearUsuario' : 'register'));
                        exit();
                    }

                    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                        $_SESSION['register'] = 'failed_email';
                        if(ob_get_length()) { ob_clean(); }
                        header('Location:'.BASE_URL.'usuario/'.(isset($_SESSION['admin']) ? 'crearUsuario' : 'register'));
                        exit();
                    }

                    if(!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/', $password)){
                        $_SESSION['register'] = 'failed_password';
                        if(ob_get_length()) { ob_clean(); }
                        header('Location:'.BASE_URL.'usuario/'.(isset($_SESSION['admin']) ? 'crearUsuario' : 'register'));
                        exit();
                    }

                    // Crea un nuevo usuario y guarda los datos en la base de datos
                    $usuario = new Usuario();
                    $usuario->setNombre($nombre);
                    $usuario->setApellidos($apellidos);
                    $usuario->setEmail($email);

                    if($usuario->existeEmail()){
                        $_SESSION['register'] = 'failed_email_duplicado';
                        if(ob_get_length()) { ob_clean(); }
                        header('Location:'.BASE_URL.'usuario/'.(isset($_SESSION['admin']) ? 'crearUsuario' : 'register'));
                        exit();
                    }

                    $usuario->setPassword(($password));
                    $usuario->setRol($rol);

                    if($usuario->guardar()){
                        Utils::deleteSession('form_data');
                        $_SESSION['register'] = 'complete';
                        if(isset($_SESSION['admin'])){
                            if(ob_get_length()) { ob_clean(); }
                            header('Location:' . BASE_URL . 'usuario/crearUsuario');
                            exit();
                        }else{
                            if(ob_get_length()) { ob_clean(); }
                            header('Location:' . BASE_URL . 'usuario/register');
                            exit();
                        }
                    }else{
                        $_SESSION['register'] = 'failed';
                        if(ob_get_length()) { ob_clean(); }
                        header('Location:'.BASE_URL.'usuario/'.(isset($_SESSION['admin']) ? 'crearUsuario' : 'register'));
                        exit();
                    }
                }else{
                    $_SESSION['register'] = 'failed';
                    if(ob_get_length()) { ob_clean(); }
                    header('Location:'.BASE_URL.'usuario/'.(isset($_SESSION['admin']) ? 'crearUsuario' : 'register'));
                    exit();
                }
            }else{
                if(ob_get_length()) { ob_clean(); }
                header('Location:'.BASE_URL);
                exit();
            }
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

                        if(ob_get_length()) { ob_clean(); }
                        header('Location:'.BASE_URL);
                        exit();
                    }else{
                        $_SESSION['login'] = 'failed';
                    }
                }else{
                    $_SESSION['login'] = 'failed';
                }
            }else{
                if(ob_get_length()) { ob_clean(); }
                header('Location:'.BASE_URL);
                exit();
            }
            if(ob_get_length()) { ob_clean(); }
            header('Location:'.BASE_URL."usuario/loginCookies");
            exit();
        }

        /**
         * Método loginCookies
         * Carga la vista de login y gestiona el inicio de sesión con cookies.
         */
        public function loginCookies(){
            Utils::isIdentity();

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

                    if(ob_get_length()) { ob_clean(); }
                    header('Location:'.BASE_URL);
                    exit();
                }
            }
            require_once 'views/usuario/login.php';
        }

        /**
         * Método logout
         * Cierra la sesión del usuario.
         */
        public function logout(){
            Utils::isNotIdentity();
            Utils::deleteSession('identity');
            Utils::deleteSession('admin');

            if(isset($_COOKIE['recuerdame'])){
                setcookie('recuerdame', '', time() - 1);
            }

            if(ob_get_length()) { ob_clean(); }
            header('Location:'.BASE_URL);
            exit(); // Asegúrate de que el script se detenga después de redirigir
        }

        /**
         * Método crearUsuario
         * Carga la vista de creación de usuario.
         */
        public function crearUsuario(){
            Utils::isAdmin();
            require_once 'views/usuario/crear.php';
        }

        /**
         * Método listaUsuarios
         * Carga la vista de la lista de usuarios.
         */
        public function listaUsuarios(){
            Utils::isAdmin();

            $usuariosPorPagina = USERS_PER_PAGE;
            $_SESSION['pagina'] = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

            $usuarios = Usuario::getAllUsers();

            $totalPaginas = max(1, ceil(count($usuarios) / $usuariosPorPagina));
            $usuarios = array_slice($usuarios, ($_SESSION['pagina'] - 1) * $usuariosPorPagina, $usuariosPorPagina);

            if($_SESSION['pagina'] < 1) {
                if(ob_get_length()) { ob_clean(); }
                header('Location:'.BASE_URL.'usuario/listaUsuarios&pagina=1');
                exit();
            }

            if($_SESSION['pagina'] > $totalPaginas) {
                if(ob_get_length()) { ob_clean(); }
                header('Location:'.BASE_URL.'usuario/listaUsuarios&pagina='.$totalPaginas);
                exit();
            }

            require_once 'views/usuario/lista.php';
        }

        public function edit(){
            Utils::isNotIdentity();

            if(isset($_GET['id'])){
                $id = $_GET['id'];
                Utils::isAdmin();

                if(Usuario::getUserPorId($id)){
                    require_once 'views/usuario/editarUsuarioLista.php';
                }else{
                    require_once 'views/usuario/editarCuenta.php';
                }
            }else{
                require_once 'views/usuario/editarCuenta.php';
            }
        }

        public function editarUsuario(){
            Utils::isNotIdentity();
            
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
                $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : null;
                $email = isset($_POST['email']) ? $_POST['email'] : null;
                $password = isset($_POST['password']) ? $_POST['password'] : null;
                $rol = isset($_POST['rol']) ? $_POST['rol'] : $_SESSION['identity']['rol'];

                $_SESSION['form_data'] = [
                    'nombre' => $nombre,
                    'apellidos' => $apellidos,
                    'email' => $email,
                    'password' => $password,
                    'rol' => $rol
                ];

                $id = isset($_GET['id']) ? $_GET['id'] : $_SESSION['identity']['id'];
                $usuarioActual = Usuario::getUserPorId($id);
                if($nombre != $usuarioActual->getNombre() || $apellidos != $usuarioActual->getApellidos() || $email != $usuarioActual->getEmail() || strlen($password) > 0 || $rol != $usuarioActual->getRol()){
                    if($nombre && !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/", $nombre)){
                        $_SESSION['edicion'] = 'failed_nombre';
                        if(ob_get_length()) { ob_clean(); }
                        header('Location:'.BASE_URL.'usuario/edit'.(isset($_GET['id']) ? "&id=" . $_GET['id'] : ""));
                        exit();
                    }

                    if($apellidos && !preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]+$/", $apellidos)){
                        $_SESSION['edicion'] = 'failed_apellidos';
                        if(ob_get_length()) { ob_clean(); }
                        header('Location:'.BASE_URL.'usuario/edit'.(isset($_GET['id']) ? "&id=" . $_GET['id'] : ""));
                        exit();
                    }

                    if($email && !filter_var($email, FILTER_VALIDATE_EMAIL)){
                        $_SESSION['edicion'] = 'failed_email';
                        if(ob_get_length()) { ob_clean(); }
                        header('Location:'.BASE_URL.'usuario/edit'.(isset($_GET['id']) ? "&id=" . $_GET['id'] : ""));
                        exit();
                    }

                    if(strlen($password) > 0 && !preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d@$!%*?&]{8,}$/', $password)){
                        $_SESSION['edicion'] = 'failed_password';
                        if(ob_get_length()) { ob_clean(); }
                        header('Location:'.BASE_URL.'usuario/edit'.(isset($_GET['id']) ? "&id=" . $_GET['id'] : ""));
                        exit();
                    }

                    $usuario = new Usuario();
                    $usuario->setId($id);
                    $usuario->setNombre($nombre);
                    $usuario->setApellidos($apellidos);
                    $usuario->setEmail($email);
                    $usuario->setPassword($password);
                    $usuario->setRol($rol);

                    if($usuario->actualizarBD()) {
                        $_SESSION['edicion'] = 'complete';
                        Utils::deleteSession('form_data');

                        if($_SESSION['identity']['id'] == $id){
                            $_SESSION['identity']['nombre'] = $nombre;
                            $_SESSION['identity']['apellidos'] = $apellidos;
                            $_SESSION['identity']['email'] = $email;
                            $_SESSION['identity']['rol'] = $rol;
                        }

                        if(isset($_GET['id'])){
                            Utils::deleteSession('edicion');
                            if(ob_get_length()) { ob_clean(); }
                            header('Location:'.BASE_URL.'usuario/listaUsuarios');
                            exit();
                        }else{
                            if(ob_get_length()) { ob_clean(); }
                            header('Location:'.BASE_URL.'usuario/edit');
                            exit();
                        }
                    }else{
                        $_SESSION['edicion'] = 'failed';
                        if(isset($_GET['id'])){
                            Utils::deleteSession('edicion');
                            if(ob_get_length()) { ob_clean(); }
                            header('Location:'.BASE_URL.'usuario/listaUsuarios');
                            exit();
                        }else{
                            if(ob_get_length()) { ob_clean(); }
                            header('Location:'.BASE_URL.'usuario/edit&id='.$id);
                            exit();
                        }
                    }
                }else{
                    $_SESSION['edicion'] = 'undefined';
                }
                if(ob_get_length()) { ob_clean(); }
                header('Location:'.BASE_URL.'usuario/edit'.(isset($_GET['id']) ? "&id=" . $_GET['id'] : ""));
                exit();
            }else{
                if(ob_get_length()) { ob_clean(); }
                header('Location:'.BASE_URL);
                exit();
            }
        }
    }
?>